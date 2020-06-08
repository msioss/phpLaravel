@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-3">Add a product</h1>
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
                <form id="create" method="post" enctype="multipart/form-data" action="{{ route('products.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" name="name"/>
                    </div>

                    @include("view._stack-photo")
                    <div class="form-group">
                        <label for="email">Description:</label>
                        <textarea class="form-control" name="description" id ="description" rows="10" cols="45" ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add product</button>

                </form>
            </div>
        </div>
    </div>
    @include("view._cropper-modal")

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
