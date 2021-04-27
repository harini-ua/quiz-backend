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
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Food recipes</li>
                <li class="breadcrumb-item"><a href="{{ route('foods.index') }}">All food recipes</a></li>
            </ol>
            <h1 class="page-title">Food recipes, ingredients and steps</h1>
            <div class="page-header-actions">
                <a href="{{ route('foods.create') }}">
                    <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                            data-original-title="Add">
                        <i class="icon wb-plus" aria-hidden="true"></i>
                    </button>
                </a>
            </div>
        </div>
        <!-- Page Content -->
        <div class="page-content container-fluid">
            <div class="example-wrap">
                <div class="row">
                    @if ($foods->count())
                        @foreach($foods as $food)
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <a href="{{route('foods.show', ['food' => $food->id])}}">
                                        <img class="card-img-top img-fluid w-full"
                                             src="{{ \Illuminate\Support\Facades\Storage::url('foods/'.$food->image) }}"
                                             alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">{{ $food->name }}</h4>
                                            <p class="card-text">{{ $food->description }}</p>
                                            <div class="row row-lg">
                                                <div class="col-md-6 col-lg-6">
                                                    <a class="btn btn-sm btn-icon btn-inverse btn-round"
                                                       data-toggle="tooltip"
                                                       data-original-title="Edit"
                                                       href="{{ route('foods.edit', ['food' => $food->id]) }}">
                                                        <i class="icon wb-pencil" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-6 col-lg-6 text-right">
                                                    <a href="{{ route('foods.destroy', ['food' => $food->id]) }}"
                                                       onclick="event.preventDefault();document.getElementById('delete{{ $food->id }}').submit();">
                                                        <button type="button"
                                                                class="btn btn-sm btn-icon btn-inverse btn-round"
                                                                data-toggle="tooltip"
                                                                data-original-title="Delete">
                                                            <i class="icon wb-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <form id="delete{{ $food->id }}"
                                                          action="{{ route('foods.destroy', ['food' => $food->id]) }}"
                                                          method="POST"
                                                          style="display: none;">
                                                        @csrf
                                                        {{ method_field('delete') }}
                                                        <input type="hidden" name="id" value="{{ $food->id }}">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4>Nothing created yet. Create event types by clicking plus button in top right corner.</h4>
                    @endif
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
@endsection
