@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Update product</h1>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br/>
                @endif
                <form id="create" method="post" action="{{ route('products.update', $data["product"]->id) }}">
                    @method('PATCH')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" name="name"
                               value="{{ $data["product"]->name }}"/>
                    </div>
                    @include("view._stack-photo")
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select class="custom-select" name="category" id="category">
                            <option
                                value="{{$data["selectedCategory"]->id}}">{{$data["selectedCategory"]->name}}</option>
                            @foreach($data["categories"] as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-3">
                        <label for="price">Price:</label>
                        <input type="text" id="price" class="form-control" name="price"
                               value="{{ $data["product"]->price }}"/>
                    </div>
                    <div class="form-group mt-3">
                        <label for="count">Count:</label>
                        <input type="number" id="count" class="form-control" name="count"
                               value="{{ $data["product"]->count }}"/>
                    </div>

                    <div class="form-group">
                        <label for="email">Description:</label>
                        <textarea class="form-control" name="description" id="description" rows="10"
                                  cols="45">{!! $data["product"]->description !!}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update product</button>

                </form>
            </div>
        </div>
    </div>
@include('view._cropper-modal')
@endsection

@section('scripts')
    <script>
        function deleteImg(id) {
            axios.get('/products/deleteImage/' + id)
                .then((resp) => {
                    console.log("Result", resp);
                });
        }

        (function ($) {
            @foreach ($data["product"]->productImages as $image)

            $('.images').prepend('<div class="img" onclick="deleteImg('+"{{$image->id}}"+')" style="background-image: url(' + "{{'/images/840_'.$image->name}}" + ');" rel="' + "{{'/images/840_'.$image->name}}" + '"><span>remove</span></div>');
            $('.images').prepend('<input type="hidden" name="productImages[]" value="' + "{{$image->id}}" + '">');
            @endforeach
        })(jQuery);
    </script>
    <script>
        (function ($) {
            $(document).ready(function () {
                //загрузка фото на клік
                uploadImage();
                //загрузка фото на клік
                function uploadImage() {
                    let cropper = null;
                    let button = $('.images .pic');
                    let dialogCropper = $("#cropperModal");
                    let images = $('.images');
                    button.on('click', function () {
                        if (cropper == null) {
                            //запуск кропера
                            const imageCropper = document.getElementById('imageCropper');
                            cropper = new Cropper(imageCropper, {
                                aspectRatio: 224 / 168,
                                viewMode: 1,
                                autoCropArea: 0.5,
                                crop(event) {
                                    // console.log(event.detail.x);
                                    // console.log(event.detail.y);
                                    // console.log(event.detail.width);
                                    // console.log(event.detail.height);
                                    // console.log(event.detail.rotate);
                                    // console.log(event.detail.scaleX);
                                    // console.log(event.detail.scaleY);
                                },
                            });
                            //обрізка малюнка
                            $("#cropImg").on("click", function (e) {
                                e.preventDefault();
                                var imgContent = cropper.getCroppedCanvas().toDataURL();
                                axios.post('/products/upload', {imageBase64: imgContent})
                                    .then((resp) => {
                                        let url = resp.data.url;
                                        let id = resp.data.id;
                                        images.prepend('<div class="img" onclick="deleteImg('+id+')" style="background-image: url(' + url + ');" rel="' + url + '"><span>remove</span></div>');
                                        images.prepend('<input type="hidden" name="productImages[]" value="' + id + '">');
                                        console.log("Result", resp);
                                    });
                                dialogCropper.modal('hide');
                            });
                        }
                        let uploader = $('<input type="file" accept="image/*" />');
                        uploader.click()
                        uploader.on('change', function () {
                            let reader = new FileReader();
                            reader.onload = function (event) {
                                dialogCropper.modal('show');
                                cropper.replace(event.target.result);
                                uploader.remove();
                                //
                            };
                            reader.readAsDataURL(uploader[0].files[0]);
                        });
                    });
                    images.on('click', '.img', function () {
                        $(this).remove();
                    });
                }
            });
        })(jQuery);
    </script>
    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('node_modules/tinymce-i18n/langs/uk.js') }}"></script>

    <script>
        tinymce.init({
            selector: 'textarea#description',
            language: "uk",
            theme: "silver",
            menubar: true,
            skin: 'oxide-dark',
            content_css: 'dark',
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table paste code help wordcount",
            ],
            toolbar:
                "undo redo | formatselect | bold italic backcolor | \
     alignleft aligncenter alignright alignjustify | \
     bullist numlist outdent indent | removeformat | help",
        });
        // $(function () {
        //     new FroalaEditor('#edit');
        // });
    </script>
@endsection
