@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu', ['active' => 4])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">Recipe: {{ $food->name }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Food recipes</li>
                <li class="breadcrumb-item"><a href="{{ route('foods.index') }}">All food recipes</a></li>
            </ol>
        </div>
        <div class="page-content">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Recipe name: {{ $food->name }}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Short description: {{ $food->description }}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Complexity level: {{ $food->complexity_number }}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Ingredients level: {{ $food->ingredients_number }}</h3>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Cover image:</h3>
                    <img src="{{ \Illuminate\Support\Facades\Storage::url('foods/'.$food->image) }}" alt="">
                </div>
            </div>
            <h4 class="example-title">Ingredients</h4>
            <p>Ingredients required for this food
                <a href="{{ route('foods.ingredients.create', ['food' => $food->id]) }}">
                    <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                            data-original-title="Add ingredients">
                        <i class="icon wb-plus" aria-hidden="true"></i>
                    </button>
                </a>
            </p>
            <div class="row">
                @foreach($food->food_ingredients as $ingredient)
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">{{ $ingredient->name }}</h4>
                                <p class="card-text">({{ $ingredient->quantity }})</p>
                                <div class="row">
                                    <a href="{{ route('foods.ingredients.destroy', ['food' => $food->id, 'ingredient' => $ingredient->id]) }}"
                                       onclick="event.preventDefault();document.getElementById('delete{{ $ingredient->id }}').submit();">
                                        <button type="button"
                                                class="btn btn-sm btn-icon btn-inverse btn-round"
                                                data-toggle="tooltip"
                                                data-original-title="Delete">
                                            <i class="icon wb-trash" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                    <form id="delete{{ $ingredient->id }}"
                                          action="{{ route('foods.ingredients.destroy', ['food' => $food->id, 'ingredient' => $ingredient->id]) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        {{ method_field('delete') }}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <h4 class="example-title">Instruction steps</h4>
            <p>These are steps that should done to make this recipe
                <a href="{{ route('foods.steps.create', ['food' => $food->id]) }}">
                    <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                            data-original-title="Add ingredients">
                        <i class="icon wb-plus" aria-hidden="true"></i>
                    </button>
                </a>
            </p>
            <div class="row">
                @foreach($food->food_steps as $step)
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title">{{ $step->description }}</h4>
                                <p class="card-text"><img style="max-width: 100%" src="{{ \Illuminate\Support\Facades\Storage::url('food-steps/'.$step->image) }}" alt=""></p>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                        <a class="btn btn-sm btn-icon btn-inverse btn-round"
                                           data-toggle="tooltip"
                                           data-original-title="Edit"
                                           href="{{ route('foods.steps.edit', ['food' => $food->id,'step' => $step->id]) }}">
                                            <i class="icon wb-pencil" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-lg-6 text-right">
                                        <a href="{{ route('foods.steps.destroy', ['food' => $food->id, 'step' => $step->id]) }}"
                                           onclick="event.preventDefault();document.getElementById('delete{{ $step->id }}').submit();">
                                            <button type="button"
                                                    class="btn btn-sm btn-icon btn-inverse btn-round"
                                                    data-toggle="tooltip"
                                                    data-original-title="Delete">
                                                <i class="icon wb-trash" aria-hidden="true"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <form id="delete{{ $step->id }}"
                                          action="{{ route('foods.steps.destroy', ['food' => $food->id, 'step' => $step->id]) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        {{ method_field('delete') }}
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
