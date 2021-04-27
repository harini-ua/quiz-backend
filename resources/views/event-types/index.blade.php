@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu', ['active' => 3])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Event types</li>
                <li class="breadcrumb-item active">All events types</li>
            </ol>
            <h1 class="page-title">Event types in application</h1>
            <div class="page-header-actions">
                <a href="{{ route('event-types.create') }}">
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
                    @if ($event_types->count())
                        @foreach($event_types as $event)
                            <div class="col-lg-3 col-md-6">
                                <div class="card">
                                    <img class="card-img-top img-fluid w-full"
                                         src="{{ \Illuminate\Support\Facades\Storage::url('event-types/'.$event->image) }}"
                                         alt="Card image cap">
                                    <div class="card-block">
                                        <h4 class="card-title">{{ $event->title }}</h4>
                                        <p class="card-text">{{ $event->description }}</p>

                                        <div class="row row-lg">
                                            <div class="col-md-6 col-lg-6">
                                                <a class="btn btn-sm btn-icon btn-inverse btn-round"
                                                   data-toggle="tooltip"
                                                   data-original-title="Edit"
                                                   href="{{ route('event-types.edit', ['event_type' => $event->id]) }}">
                                                    <i class="icon wb-pencil" aria-hidden="true"></i>
                                                </a>
                                            </div>

                                            <div class="col-md-6 col-lg-6 text-right">
                                                <a href="{{ route('event-types.destroy', ['event_type' => $event->id]) }}"
                                                   onclick="event.preventDefault();document.getElementById('delete{{ $event->id }}').submit();">
                                                    <button type="button"
                                                            class="btn btn-sm btn-icon btn-inverse btn-round"
                                                            data-toggle="tooltip"
                                                            data-original-title="Delete">
                                                        <i class="icon wb-trash" aria-hidden="true"></i>
                                                    </button>
                                                </a>
                                                <form id="delete{{ $event->id }}"
                                                      action="{{ route('event-types.destroy', ['event_type' => $event->id]) }}"
                                                      method="POST"
                                                      style="display: none;">
                                                    @csrf
                                                    {{ method_field('delete') }}
                                                    <input type="hidden" name="id" value="{{ $event->id }}">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
