@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu',['active'=>4])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">Adding new ingredient for {{$food->name}}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Food recipes</li>
                <li class="breadcrumb-item"><a href="{{route('foods.show',['food'=>$food->id])}}">{{$food->name}}</a></li>
            </ol>
        </div>
        <div class="page-content">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Fill the form</h3>
                </div>
                <div class="panel-body container-fluid">
                    <form method="POST" action="{{ route('foods.ingredients.store',['food'=>$food->id]) }}">
                        @csrf
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Name of ingredient</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Cheese" name="name" value="{{old('name')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Quantity and unit</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: 100g cheese" name="quantity" value="{{old('quantity')}}">
                                </div>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Panel Form Elements -->
        </div>
    </div>
@endsection
