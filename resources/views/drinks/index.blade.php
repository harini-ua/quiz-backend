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
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Drink recipes</li>
                <li class="breadcrumb-item"><a href="{{route('drinks.index')}}">All drink recipes</a></li>
            </ol>
            <h1 class="page-title">Drink recipes, ingredients and steps</h1>
            <div class="page-header-actions">
                <a href="{{route('drinks.create')}}">
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
                    @if ($drinks->count())
                        @foreach($drinks as $drink)
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <a href="{{route('drinks.show',['drink'=>$drink->id])}}">
                                        <img class="card-img-top img-fluid w-full"
                                             src="{{Storage::url('drinks/'.$drink->image)}}"
                                             alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">{{$drink->name}}</h4>
                                            <p class="card-text">{{$drink->description}}</p>
                                            <div class="row row-lg">
                                                <div class="col-md-6 col-lg-6">
                                                    <a class="btn btn-sm btn-icon btn-inverse btn-round"
                                                       data-toggle="tooltip"
                                                       data-original-title="Edit"
                                                       href="{{ route('drinks.edit', ['drink'=>$drink->id]) }}">
                                                        <i class="icon wb-pencil" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-6 col-lg-6 text-right">
                                                    <a href="{{route('drinks.destroy',['drink'=>$drink->id])}}"
                                                       onclick="event.preventDefault();document.getElementById('delete{{$drink->id}}').submit();">
                                                        <button type="button"
                                                                class="btn btn-sm btn-icon btn-inverse btn-round"
                                                                data-toggle="tooltip"
                                                                data-original-title="Delete">
                                                            <i class="icon wb-trash" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <form id="delete{{$drink->id}}"
                                                          action="{{route('drinks.destroy',['drink'=>$drink->id])}}"
                                                          method="POST"
                                                          style="display: none;">
                                                        @csrf
                                                        {{method_field('delete')}}
                                                        <input type="hidden" name="id" value="{{$drink->id}}">
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
