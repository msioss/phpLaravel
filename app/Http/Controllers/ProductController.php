<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\ProductImage;
use App\Category;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use function GuzzleHttp\Promise\all;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all('id', 'name');
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'price' => 'required'
        ]);

        $product = new Product([
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'category_id' => $request->get('category'),
            'count' => $request->get('count'),
            'description' => $request->get('description')
        ]);
        $product->save();

        $listImages = $request->get("productImages");
        foreach ($listImages as $id) {
            $pi = ProductImage::find($id);
            $pi->product_id = $product->id;
            $pi->save();
        }

        return redirect('/products')->with('success', 'Продукт успішно збережено!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('products._specific-product-view', ['product' => $product]);
    }

    public function home()
    {
        $products = Product::all();
        //$product = Product::find(1);
        //$listImages = $product->productImages;

        return view('home', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all('id', 'name');
        $selectedCategory=$categories->find($product->category_id);
        $data=array('product'=>$product, 'categories'=>$categories, 'selectedCategory'=>$selectedCategory);
        return view('products.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category' => 'required',
            'price' => 'required'
        ]);

        $product = Product::find($id);
        $product->name =  $request->get('name');
        $product->description = $request->get('description');
        $product->category_id = $request->get('category');
        $product->price = $request->get('price');
        $product->save();

        return redirect('/')->with('success', 'Product updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/')->with('success', 'Product deleted!');
    }

    public function upload(Request $request)
    {
        $base64_image = $request->get("imageBase64");
        $img_url = Str::uuid() . '.jpg';
        $path = public_path('images/105_') . $img_url;
        my_image_resize(105, 80, $path, $base64_image);
        $path = public_path('images/420_') . $img_url;
        my_image_resize(420, 320, $path, $base64_image);
        $path = public_path('images/840_') . $img_url;
        my_image_resize(840, 640, $path, $base64_image);

        $productImage = new ProductImage([
            'name' => $img_url,
            'priority' => 1
        ]);
        $productImage->save();

        return response()->json(['id' => $productImage->id, 'url' => '/images/420_' . $img_url]);
    }


}

function my_image_resize($width, $height, $path, $data) //32x32
{
    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $imgString = base64_decode($data);

    //Оригінал висота і ширина
    $image_resize = Image::make($data);
    $w = $image_resize->width();
    $h = $image_resize->height();
    $maxSize = 0;
    //Обчислюємо максмильан знечення або ширина або висота
    if (($w > $h) and ($width > $height)) //204>247 and 32>32
        $maxSize = $width;
    else
        $maxSize = $height; //32
    //MaxSize=32
    $width = $maxSize; //32
    $height = $maxSize; //32
    $ration_orig = $w / $h; //204/247=0.82
    if (1 > $ration_orig) //1>0.82 вірно
    {
        $width = ceil($height * $ration_orig); /*32*0.82=26.24 = 27 */     //34- all //10- records page  ceil(3.4)
    } else//Хибно
    {
        $height = ceil($width / $ration_orig);
    }
    //27x32

    //Створюємо новий файл
    $image = imagecreatefromstring($imgString);
    $tmp = imagecreatetruecolor($width, $height); //розмір нового зображення 27x32
    imagecopyresampled($tmp, $image,
        0, 0,
        0, 0,
        $width, $height,
        $w, $h
    );
    //Збереження зображення
    imagejpeg($tmp, $path, 30);
    //imagepng($tmp,$path,5);
    //imagegif($tmp,$path);


    return $path;
//    //Очисчаємо память
    imagedestroy($image);
    imagedestroy($tmp);
}
