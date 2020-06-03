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
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{ $category->name }}</th>
                        <td><img src="/images/{{ $category->image }}" alt="prodImg" style="height: 200px;width: 200px;border-radius: 20px"/></td>
                        <td>
                            <div class="p-2" style="border: #7f7d7d 0.5px solid; border-radius: 3px;">{!! $category->description  !!}</div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div>
            </div>
@endsection
