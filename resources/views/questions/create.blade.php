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
            <h1 class="page-title">Creating new question for quiz</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Quiz</li>
                <li class="breadcrumb-item"><a href="{{ route('questions.index') }}">All quiz questions</a></li>
            </ol>
        </div>
        <div class="page-content">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Fill the form</h3>
                </div>
                <div class="panel-body container-fluid">
                    <form method="POST" action="{{ route('questions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example Placeholder -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description overlay (if needed) - English</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description">
                                </div>
                                <!-- End Example Placeholder -->
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example Placeholder -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description overlay (if needed) - Spanish</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description_spanish">
                                </div>
                                <!-- End Example Placeholder -->
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example Placeholder -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description overlay (if needed) - German</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description_german">
                                </div>
                                <!-- End Example Placeholder -->
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6">
                                <div class="example-wrap m-sm-0">
                                    <h4 class="example-title">Category of question</h4>
                                    <div class="form-group">
                                        <select class="form-control" name="category">
                                            <option value="" disabled>Please select</option>
                                            <option value="1">How would you call it?</option>
                                            <option value="2">What can you see?</option>
                                            <option value="3">What is this sound?</option>
                                            <option value="4">What is it made of?</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example File Upload -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Image</h4>
                                    <div class="form-group">
                                        <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                            <input type="text" class="form-control" readonly="" name="image_file">
                                            <div class="input-group-append">
                                                <span class="btn btn-success btn-file">
                                                  <i class="icon wb-upload" aria-hidden="true"></i>
                                                  <input type="file" name="image_file" multiple="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Example File Upload -->
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example File Upload -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Or audio (mp3 file)</h4>
                                    <div class="form-group">
                                        <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                            <input type="text" class="form-control" readonly="" name="audio_file">
                                            <div class="input-group-append">
                                                <span class="btn btn-success btn-file">
                                                  <i class="icon wb-upload" aria-hidden="true"></i>
                                                  <input type="file" name="audio_file" multiple="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Example File Upload -->
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
