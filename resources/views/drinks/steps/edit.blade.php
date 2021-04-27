@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu', ['active' => 5])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">Editing step for {{ $drink->name }}</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Drink recipes</li>
                <li class="breadcrumb-item"><a href="{{ route('drinks.show', ['drink' => $drink->id]) }}">{{ $drink->name }}</a></li>
            </ol>
        </div>
        <div class="page-content">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Fill the form</h3>
                </div>
                <div class="panel-body container-fluid">
                    <form method="POST" action="{{ route('drinks.steps.update', ['drink' => $drink->id, 'step' => $step->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short instruction (English)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="Text for this step" name="description" value="{{ old('description') ?? $step->description }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short instruction (Spanish)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="Text for this step" name="description_spanish" value="{{ old('description_spanish') ?? $step->description_spanish }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short instruction (German)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="Text for this step" name="description_german" value="{{ old('description_german') ?? $step->description_german }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Image for step</h4>
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
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">OR video for step</h4>
                                    <div class="form-group">
                                        <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                            <input type="text" class="form-control" readonly="" name="video_file">
                                            <div class="input-group-append">
                                                <span class="btn btn-success btn-file">
                                                  <i class="icon wb-upload" aria-hidden="true"></i>
                                                  <input type="file" name="video_file" multiple="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-danger btn-flat">
                            If you don't want to change current image/video that you see bellow, just leave that two fields untouched.
                        </div>
                        @if($step->video)
                            <video src="{{ \Illuminate\Support\Facades\Storage::url($step->video) }}" style="max-width: 300px;max-height: 300px" controls></video>
                        @elseif($step->image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url('drink-steps/'.$step->image) }}" alt="" style="max-width: 300px;max-height: 300px;">
                        @endif
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
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Panel Form Elements -->
        </div>
    </div>
@endsection
