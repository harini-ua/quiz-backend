@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu',['active'=>5])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">Adding new ingredient for {{$drink->name}}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Drink recipes</li>
                <li class="breadcrumb-item"><a href="{{route('drinks.show',['drink'=>$drink->id])}}">{{$drink->name}}</a></li>
            </ol>
        </div>
        <div class="page-content">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Fill the form</h3>
                </div>
                <div class="panel-body container-fluid">
                    <form method="POST" action="{{ route('drinks.ingredients.store',['drink'=>$drink->id]) }}">
                        @csrf
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Name of ingredient</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Liqor43" name="name" value="{{old('name')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Quantity and unit</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: 200ml" name="quantity" value="{{old('quantity')}}">
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
