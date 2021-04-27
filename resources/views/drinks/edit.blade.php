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
            <h1 class="page-title">Editing drink recipe</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Drink recipes</li>
                <li class="breadcrumb-item"><a href="{{ route('drinks.index') }}">All drinks recipes</a></li>
            </ol>
        </div>
        <div class="page-content">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Fill the form</h3>
                </div>
                <div class="panel-body container-fluid">
                    <form method="POST" action="{{ route('drinks.update', ['drink' => $food->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example Placeholder -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Name of drink (English)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Pinxtos" name="name" value="{{ old('name') ?? $food->name }}">
                                </div>
                                <!-- End Example Placeholder -->
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example Placeholder -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Name of drink (Spanish)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Pinxtos" name="name_spanish" value="{{ old('name_spanish') ?? $food->name_spanish }}">
                                </div>
                                <!-- End Example Placeholder -->
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <!-- Example Placeholder -->
                                <div class="example-wrap">
                                    <h4 class="example-title">Name of drink (German)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Pinxtos" name="name_german" value="{{ old('name_german') ?? $food->name_german }}">
                                </div>
                                <!-- End Example Placeholder -->
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description (English)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description"
                                           value="{{ old('description') ?? $food->description }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description (Spanish)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description_spanish"
                                           value="{{ old('description_spanish') ?? $food->description_spanish }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description (German)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description_german"
                                           value="{{ old('description_german') ?? $food->description_german }}">
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Cover image</h4>
                                    <div class="form-group">
                                        <div class="input-group input-group-file" data-plugin="inputGroupFile">
                                            <input type="text" class="form-control" readonly="" name="image_file">
                                            <div class="input-group-append">
                                                <span class="btn btn-success btn-file">
                                                  <i class="icon wb-upload" aria-hidden="true"></i>
                                                  <input type="file" name="image_file" multiple="" id="input_image">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6">
                                <div class="example-wrap m-sm-0">
                                    <h4 class="example-title">Complexity level</h4>
                                    <div class="form-group">
                                        <select class="form-control" name="complexity_number">
                                            <option value="1" {{ selected($food->complexity_number == 1) }}>1 (easy)</option>
                                            <option value="2" {{ selected($food->complexity_number == 2) }}>2</option>
                                            <option value="3" {{ selected($food->complexity_number == 3) }}>3</option>
                                            <option value="4" {{ selected($food->complexity_number == 4) }}>4</option>
                                            <option value="5" {{ selected($food->complexity_number == 5) }}>5 (hard)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6">
                                <div class="example-wrap m-sm-0">
                                    <h4 class="example-title">Ingredients level</h4>
                                    <div class="form-group">
                                        <select class="form-control" name="ingredients_number">
                                            <option value="1" {{ selected($food->ingredients_number == 1) }}>1 (one or two)</option>
                                            <option value="2" {{ selected($food->ingredients_number == 2) }}>2</option>
                                            <option value="3" {{ selected($food->ingredients_number == 3) }}>3</option>
                                            <option value="4" {{ selected($food->ingredients_number == 4) }}>4</option>
                                            <option value="5" {{ selected($food->ingredients_number == 5) }}>5 (5 or more)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Minutes to prepare</h4>
                                    <input type="number" class="form-control form-control-lg" placeholder="example: 10"
                                           name="minutes" value="{{ old('minutes') ?? $food->minutes }}">
                                </div>
                            </div>
                        </div>
                        @include('partials.food-drink-preview', [
                            'image' => \Illuminate\Support\Facades\Storage::url('foods/'.$food->image),
                            'type' => 'food',
                            'title' => $food->name,
                            'text' => $food->description,
                            'minutes' => $food->minutes,
                            'ingredients' => $food->ingredients_number,
                            'complexity' => $food->complexity_number
                        ])
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

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            $(document).ready(function () {

                $('input[name ="name"]').keyup(function () {
                    $('#title').html($(this).val());
                });

                $('input[name ="description"]').keyup(function () {
                    $('#text').html($(this).val());
                });

                $('input[name ="minutes"]').keyup(function () {

                    $('#minutes_preview').html("");

                    $(this).val().split('').forEach(function (item) {
                        var divs = '<div class="slider__slide-recipe__about-time__item"><span class="slider__slide-recipe__about-time__item-text">'+ item +'</span></div>';
                        $('#minutes_preview').append(divs);
                    });
                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#image_preview').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }
                $("#input_image").change(function() {
                    readURL(this);
                });
            });
        });
    </script>

@endsection
