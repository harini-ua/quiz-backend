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
            <h1 class="page-title">Recipe: {{$drink->name}}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Drink recipes</li>
                <li class="breadcrumb-item"><a href="{{route('drinks.index')}}">All drink recipes</a></li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Recipe name: {{$drink->name}}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Short description: {{$drink->description}}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Complexity level: {{$drink->complexity_number}}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Ingredients level: {{$drink->ingredients_number}}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Cover image:</h3>
                    <img src="{{Storage::url('drink/'.$drink->image)}}" alt="">
                </div>
            </div>
            <h4 class="example-title">Ingredients</h4>
            <p>Ingredients required for this drink
                <a href="{{route('drinks.ingredients.create',['drink'=>$drink->id])}}">
                    <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                            data-original-title="Add ingredients">
                        <i class="icon wb-plus" aria-hidden="true"></i>
                    </button>
                </a>
            </p>
            <div class="row">
                @foreach($drink->drink_ingredients as $ingredient)
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">{{$ingredient->name}}</h4>
                                <p class="card-text">({{$ingredient->quantity}})</p>

                                <div class="row">
                                    <a href="{{route('drinks.ingredients.destroy',['drink'=>$drink->id, 'ingredient'=>$ingredient->id])}}"
                                       onclick="event.preventDefault();document.getElementById('delete{{$ingredient->id}}').submit();">
                                        <button type="button"
                                                class="btn btn-sm btn-icon btn-inverse btn-round"
                                                data-toggle="tooltip"
                                                data-original-title="Delete">
                                            <i class="icon wb-trash" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                    <form id="delete{{$ingredient->id}}"
                                          action="{{route('drinks.ingredients.destroy',['drink'=>$drink->id, 'ingredient'=>$ingredient->id])}}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        {{method_field('delete')}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <h4 class="example-title">Instruction steps</h4>
            <p>These are steps that should done to make this recipe
                <a href="{{route('drinks.steps.create',['drink'=>$drink->id])}}">
                    <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                            data-original-title="Add ingredients">
                        <i class="icon wb-plus" aria-hidden="true"></i>
                    </button>
                </a>
            </p>
            <div class="row">
                @foreach($drink->drink_steps as $step)
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">{{$step->description}}</h4>
                                <p class="card-text"><img style="max-width: 100%"
                                                          src="{{Storage::url('drink-steps/'.$step->image)}}" alt="">
                                </p>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <a class="btn btn-sm btn-icon btn-inverse btn-round"
                                           data-toggle="tooltip"
                                           data-original-title="Edit"
                                           href="{{ route('drinks.steps.edit', ['drink'=>$drink->id,'step'=>$step->id]) }}">
                                            <i class="icon wb-pencil" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-lg-6 text-right">
                                        <a href="{{route('drinks.steps.destroy',['drink'=>$drink->id, 'step'=>$step->id])}}"
                                           onclick="event.preventDefault();document.getElementById('delete{{$step->id}}').submit();">
                                            <button type="button"
                                                    class="btn btn-sm btn-icon btn-inverse btn-round"
                                                    data-toggle="tooltip"
                                                    data-original-title="Delete">
                                                <i class="icon wb-trash" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <form id="delete{{$step->id}}"
                                          action="{{route('drinks.steps.destroy',['drink'=>$drink->id, 'step'=>$step->id])}}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        {{method_field('delete')}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
