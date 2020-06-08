<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            //'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'base64Image' => 'required',
            'description'=>'required'
        ]);
        $type = explode('/', mime_content_type(request()->base64Image))[1];

        $img_url = Str::uuid().'.'.$type;
        $path = public_path('images/').$img_url;

        $image_resize=Image::make(file_get_contents(request()->base64Image));
        //$image_resize->resize(300, 300);
        $image_resize->save($path);
        compressImage($image_resize->width(), $image_resize->height(), $path,$type);

        //$imageName = Str::uuid().'.'.request()->base64Image->extension();
        //request()->base64Image->move(public_path('images'), $imageName);

        $category = new Category([
            'name' => $request->get('name'),
            //'image' => $imageName,
            'image' => $img_url,
            'description' => $request->get('description')
        ]);
        $category->save();
        return redirect('/categories')->with('success', 'Category saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
function compressImage($width, $height, $path,$type)
{
    list($w,$h)= getimagesize($path);
    $maxSize=0;
    if(($w>$h) and ($width>$height))
        $maxSize=$width;
    else
        $maxSize=$height;
    $width=$maxSize;
    $height=$maxSize;
    $ration_orig=$w/$h;
    if(1>$ration_orig)
    {
        $width=ceil($height*$ration_orig);
    }
    else
    {
        $height=ceil($width/$ration_orig);
    }

    $imgString=file_get_contents($path);
    $image=imagecreatefromstring($imgString);
    $tmp=imagecreatetruecolor($width,$height);
    imagecopyresampled($tmp,$image,
        0,0,
        0,0,
        $width, $height,
        $w,$h
    );

    switch($type)
    {
        case 'jpeg' || 'jpg':
            imagejpeg($tmp,$path,30);
            break;
        case 'png':
            imagepng($tmp,$path,10);
            break;
        case 'gif':
            imagegif($tmp,$path);
            break;
        default:
            exit;
            break;
    }
    //return $path;
    imagedestroy($image);
    imagedestroy($tmp);
}
