@extends('base')

@section('main')
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/froala_editor.css">
    <link rel="stylesheet" href="/css/froala_style.css">
    <link rel="stylesheet" href="/css/plugins/code_view.css">
    <link rel="stylesheet" href="/css/plugins/image_manager.css">
    <link rel="stylesheet" href="/css/plugins/image.css">
    <link rel="stylesheet" href="/css/plugins/table.css">
    <link rel="stylesheet" href="/css/plugins/video.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Add a category</h1>
            <div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div><br />
                @endif
                <form id="create" method="post" enctype="multipart/form-data" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" name="name"/>
                    </div>
                    <div class="form-group">
                        <img class="choose-image" src="{{ asset('images/200_default.png') }}"
                             id="chooseImage" alt="Обрати фото">
                        <input type="hidden" name="image" id="image">
                        <input type="file" id="selectImage" class="d-none">
                    </div>
                    <div class="form-group">
{{--                        <label for="description">Description:</label>--}}
{{--                        <textarea id="description" rows="10" cols="35" class="form-control" name="description"></textarea>--}}
                        <textarea name="description" id='edit' style="margin-top: 30px;" placeholder="Type some text">
                            <h1>Description</h1>
{{--                            <p>The editor can also be initialized on a textarea.</p>--}}
                        </textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add category</button>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <img id="imageCropper" src="{{ asset('images/200_default.png') }}" height="400">
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="img-rotation" class="btn btn-success"><i class="fa fa-repeat" aria-hidden="true"></i></a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button id="cropImg" class="btn btn-primary">Обрізати фото</button>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}" ></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
    <script type="text/javascript" src="/js/froala_editor.min.js"></script>
    <script type="text/javascript" src="/js/plugins/align.min.js"></script>
    <script type="text/javascript" src="/js/plugins/code_beautifier.min.js"></script>
    <script type="text/javascript" src="/js/plugins/code_view.min.js"></script>
    <script type="text/javascript" src="/js/plugins/draggable.min.js"></script>
    <script type="text/javascript" src="/js/plugins/image.min.js"></script>
    <script type="text/javascript" src="/js/plugins/image_manager.min.js"></script>
    <script type="text/javascript" src="/js/plugins/link.min.js"></script>
    <script type="text/javascript" src="/js/plugins/lists.min.js"></script>
    <script type="text/javascript" src="/js/plugins/paragraph_format.min.js"></script>
    <script type="text/javascript" src="/js/plugins/paragraph_style.min.js"></script>
    <script type="text/javascript" src="/js/plugins/table.min.js"></script>
    <script type="text/javascript" src="/js/plugins/video.min.js"></script>
    <script type="text/javascript" src="/js/plugins/url.min.js"></script>
    <script type="text/javascript" src="/js/plugins/entities.min.js"></script>
    <script>
        jQuery(function () {
            //фото по якому клікаємо і обираємо файл
            $chooseImage = $("#chooseImage");
            //текстове поле із base64
            $base64Image = $("#image");
            //скритий інпут для вибору файла
            $selectImage = $("#selectImage");
            let dialogCropper = $("#cropperModal");
            //клікнули по фото і клікаємо по скритому інпуту файл
            $chooseImage.on("click", function () {
                $selectImage.click();
            });
            //коли обрали файл
            $selectImage.on("change", function() {
                if (this.files && this.files.length) {
                    let file = this.files[0];
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        dialogCropper.modal('show');
                        cropper.replace(e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
            //запуск кропера
            const imageCropper = document.getElementById('imageCropper');
            const cropper = new Cropper(imageCropper, {
                aspectRatio: 1/1,
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
            //поворот малюнка
            $("#img-rotation").on("click",function (e) {
                e.preventDefault();
                cropper.rotate(45);
            });
            //обрізка малюнка
            $("#cropImg").on("click", function (e) {
                e.preventDefault();
                let imgContent = cropper.getCroppedCanvas().toDataURL();
                $chooseImage.attr("src", imgContent);
                dialogCropper.modal('hide');
                $base64Image.val(imgContent);
            });
        })
    </script>
    <script>
        (function () {
            const editorInstance = new FroalaEditor('#edit', {
                enter: FroalaEditor.ENTER_P,
                placeholderText: null,
                events: {
                    initialized: function () {
                        const editor = this
                        this.el.closest('form').addEventListener('submit', function (e) {
                            //console.log(editor.$oel.val())

                        })
                    }
                }
            })
        })()
    </script>
@endsection
