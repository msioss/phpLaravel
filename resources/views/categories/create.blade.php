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
                <form method="post" enctype="multipart/form-data" action="{{ route('categories.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" name="name"/>
                    </div>

                    <div style="display: flex; flex-direction: column;" class="form-group">
                        <div class="custom-file mb-3">
                            <label class="custom-file-label" for="customFile">Choose a photo</label>
                            <input onchange="loadFile(event)" id="customFile" name="image" type="file" class="custom-file-input">
                        </div>
                        <img style="height: 200px; width: 200px" id="output" src="/images/200_default.png" alt="">
                        <script>
                            let loadFile = function(event) {
                                let output = document.getElementById('output');
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
                                    URL.revokeObjectURL(output.src) // free memory
                                }
                            };
                        </script>
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
        function cl(){
            console.log(getElementById("edit"));
        }
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

    <script src={{ asset('js/app.js') }}></script>
    <script>
        jQuery(function () {
            //alert("weed");
        })
    </script>
@endsection
