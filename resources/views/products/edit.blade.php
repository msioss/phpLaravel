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

@endsection

@section('scripts')
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
