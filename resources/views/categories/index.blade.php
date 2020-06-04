@extends('base')

@section('main')
    <div class="row">
        <div class="col-sm-12">

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
        <div class="col-sm-12">
            <h1 class="display-3">Categories</h1>
            <div>
                <a style="margin: 19px;" href="{{ route('categories.create')}}" class="btn btn-primary">New category</a>
            </div>
            <div id="content" class="container">
                <div class="row" style="display: flex; justify-content: center">
                    @foreach ($categories as $category)
                        <a style="cursor: pointer" data-toggle="modal" data-target="#{{ $category->name }}">
                            <div class="card px-2 m-2">
                                <img class="p-2 card-img-top" style="border-radius: 20px; width: 180px; height: 180px"
                                     src="/images/{{ $category->image }}" alt="">
                                <div class="card-body">
                                    <h3 class="card-text" style="text-align: center;">{{ $category->name }}</h3>
                                </div>
                            </div>
                        </a>

                        <div class="modal fade" id="{{ $category->name }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="text-transform: uppercase" id="exampleModalLongTitle">{{ $category->name }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="p-2 card-img-top" style="border-radius: 20px; border: 0.5px silver solid; width: 250px; height: 250px"
                                             src="/images/{{ $category->image }}" alt="">
                                        <div class="p-2" style="border-radius: 3px;">{!! $category->description  !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
{{--            <table class="table table-striped">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th scope="col">Name</th>--}}
{{--                    <th scope="col">Image</th>--}}
{{--                    <th scope="col">Description</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach ($categories as $category)--}}
{{--                    <tr>--}}
{{--                        <th scope="row">{{ $category->name }}</th>--}}
{{--                        <td><img src="/images/{{ $category->image }}" alt="prodImg"--}}
{{--                                 style="height: 200px;width: 200px;border-radius: 20px"/></td>--}}
{{--                        <td>--}}
{{--                            <div class="p-2"--}}
{{--                                 style="border: #7f7d7d 0.5px solid; border-radius: 3px;">{!! $category->description  !!}</div>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
{{--                </tbody>--}}
{{--            </table>--}}

            <div>
            </div>
@endsection
