@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu', ['active' => 6])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Quiz</li>
                <li class="breadcrumb-item active">All quiz questions</li>
            </ol>
            <h1 class="page-title">All quiz questions</h1>
            <div class="page-header-actions">
                <a href="{{ route('questions.create') }}">
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
                    @if ($questions->count())
                        @foreach($questions as $question)
                            <div class="col-lg-4 col-md-6">
                                <div class="card">
                                    <img class="card-img-top img-fluid w-full"
                                         src="{{ \Illuminate\Support\Facades\Storage::url('questions/'.$question->image) }}"
                                         alt="Card image cap">
                                    <div class="card-block">
                                        <h4 class="card-title">{{ $question->description }}</h4>
                                        <p class="card-text">
                                            <strong>Category: </strong>
                                            @if ($question->category == 1)
                                                How would you call it?
                                            @elseif ($question->category == 2)
                                                What can you see?
                                            @elseif ($question->category == 3)
                                                What is this sound?
                                            @else
                                                What is it made of?
                                            @endif
                                        </p>
                                        <div class="row row-lg">
                                            <div class="col-md-6 col-lg-6">
                                                <a class="btn btn-sm btn-icon btn-inverse btn-round"
                                                   data-toggle="tooltip"
                                                   data-original-title="Edit"
                                                   href="{{ route('questions.edit', ['question' => $question->id]) }}">
                                                    <i class="icon wb-pencil" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                            <a href="{{ route('questions.destroy', ['question' => $question->id]) }}"
                                               onclick="event.preventDefault();document.getElementById('delete{{ $question->id }}').submit();">
                                                <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round"
                                                        data-toggle="tooltip"
                                                        data-original-title="Delete">
                                                    <i class="icon wb-trash" aria-hidden="true"></i>
                                                </button>
                                            </a>
                                            <form id="delete{{ $question->id }}"
                                                  action="{{ route('questions.destroy', ['question' => $question->id]) }}"
                                                  method="POST"
                                                  style="display: none;">
                                                @csrf
                                                {{ method_field('delete') }}
                                                <input type="hidden" name="id" value="{{ $question->id }}">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h4>Nothing created yet. Create first question to begin.</h4>
                    @endif
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
@endsection
