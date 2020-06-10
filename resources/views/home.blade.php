@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-sm-12">

            @if(session()->get('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="container">

                    <div class="row">
                        @foreach ($products as $product)

                            <div class="card col-md-4 col-sm-6 p-2" style="width: 18rem;">
                                <img class="card-img-top mt-2" style="border-radius: 10px"
                                     src={{'images/420_'.$product->productImages[0]->name}} alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->price }}</p>
                                    <div style="display: flex; justify-content: space-around">
                                        <a href="{{"/products/".$product->id}}" class="btn btn-primary">More info</a>
                                        <a href="{{ route('products.edit',$product->id)}}" class="btn btn-primary">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
