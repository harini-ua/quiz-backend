@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu',['active'=>3])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">Creating new event type</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Event types</li>
                <li class="breadcrumb-item"><a href="{{route('event-types.index')}}">All event types</a></li>
            </ol>
        </div>

        <div class="page-content">
            <!-- Panel Form Elements -->
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Fill the form</h3>
                </div>
                <div class="panel-body container-fluid">
                    <form method="POST" action="{{ route('event-types.update',['event_type'=>$event_type->id]) }}" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf

                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Title for event type (English)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Dinner for two" name="title" value="{{$event_type->title}}">
                                </div>
                            </div>
                        </div>

                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Title for event type (Spanish)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Dinner for two" name="title_spanish" value="{{$event_type->title_spanish}}">
                                </div>
                            </div>
                        </div>

                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Title for event type (German)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="example: Dinner for two" name="title_german" value="{{$event_type->title_german}}">
                                </div>
                            </div>
                        </div>

                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description" value="{{$event_type->description}}">
                                </div>
                            </div>
                        </div>

                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description (Spanish)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description_spanish" value="{{$event_type->description_spanish}}">
                                </div>
                            </div>
                        </div>

                        <div class="row row-lg">
                            <div class="col-md-6 col-lg-6">
                                <div class="example-wrap">
                                    <h4 class="example-title">Short description (German)</h4>
                                    <input type="text" class="form-control" id="inputPlaceholder"
                                           placeholder="enter description here" name="description_german" value="{{$event_type->description_german}}">
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
                      <input type="file" name="image_file" multiple="">
                    </span>
                                            </div>

                                        </div>
                                        <div class="alert-danger p-2">Only use this option if you want to change current image!</div>
                                    </div>
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
                            <div class="col-md-6 col-lg-6">
                                <a class="btn btn-danger btn-block" href="{{route('event-types.index')}}">Cancel</a>
                            </div>
                        </div>

                    </form>



                    <style>
                        .slider {
                            width: 375px;
                        }

                        .slider-wrap {
                            margin-bottom: 15px;
                            padding: 0 30px;
                        }

                        .slider__title {
                            display: block;
                            margin-bottom: 15px;
                            text-align: center;
                            font-size: 20;
                            font-weight: bold;
                            color: #f3e03a;
                        }

                        .slider__title span {
                            color: white;
                        }

                        .slider__slide {
                            position: relative;
                            border-radius: 25px;
                            width: 100%;
                        }

                        .slider__slide:focus {
                            outline: none;
                            -webkit-box-shadow: none;
                            box-shadow: none;
                        }

                        .slider__slide--active::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: rgba(0, 0, 0, 0.6);
                            border-radius: 25px;
                            z-index: 2;
                        }

                        .slider__slide--active .slider__slide-icon {
                            opacity: 1;
                        }

                        .slider__slide-icon {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            -webkit-transform: translate(-50%, -50%);
                            transform: translate(-50%, -50%);
                            z-index: 3;
                            opacity: 0;
                            -webkit-transition: 0.3s ease-in;
                            transition: 0.3s ease-in;
                        }

                        .slider__slide-img {
                            position: relative;
                            display: -webkit-box;
                            display: -ms-flexbox;
                            display: flex;
                            -webkit-box-orient: vertical;
                            -webkit-box-direction: normal;
                            -ms-flex-direction: column;
                            flex-direction: column;
                            -webkit-box-pack: end;
                            -ms-flex-pack: end;
                            justify-content: flex-end;
                            width: 100%;
                            height: 280px;
                        }

                        .slider__slide-img img:not(.slider-quiz__logo) {
                            position: absolute;
                            left: 0;
                            bottom: 0;
                            display: block;
                            border-top-left-radius: 25px;
                            border-top-right-radius: 25px;
                            width: 100%;
                            height: 100%;
                            -o-object-fit: cover;
                            object-fit: cover;
                        }

                        .slider__slide-img .slider__slide-img__text {
                            display: block;
                            margin-bottom: 10px;
                            line-height: 1;
                            padding-left: 15px;
                            font-size: 40px;
                            font-weight: bold;
                            color: #f3e03a;
                            z-index: 1;
                        }

                        .slider__slide-img .slider__slide-img__text span {
                            color: #fff;
                        }

                        .slider__slide-text-wrap {
                            padding: 10px;
                            text-align: center;
                            background-color: #f3e03a;
                            border-bottom-left-radius: 25px;
                            border-bottom-right-radius: 25px;
                        }

                        .slider__slide-title {
                            font-size: 20px;
                            color: black;
                            font-weight: bold;
                            line-height: 1;
                        }

                        .slider__slide-title span {
                            color: white;
                        }

                        .slider__slide-text {
                            display: block;
                            font-size: 13px;
                        }

                        .slick-slider {
                            width: calc(100% + 60px);
                            margin-left: -30px;
                        }

                        .slick-slide {
                            padding: 0 30px;
                        }

                        .slick-track {
                            display: -webkit-box;
                            display: -ms-flexbox;
                            display: flex;
                        }

                        .slick-dots {
                            display: -webkit-box !important;
                            display: -ms-flexbox !important;
                            display: flex !important;
                            -webkit-box-pack: center;
                            -ms-flex-pack: center;
                            justify-content: center;
                            -webkit-box-align: start;
                            -ms-flex-align: start;
                            align-items: flex-start;
                            margin-top: 20px;
                        }

                        .slick-dots li {
                            position: relative;
                            display: inline-block;
                            margin: 0 5px;
                            padding: 0;
                            width: 10px;
                            height: 20px;
                            cursor: pointer;
                        }

                        .slick-dots button {
                            font-size: 0;
                            line-height: 0;
                            display: block;
                            padding: 5px;
                            height: 8px;
                            width: 8px;
                            color: transparent;
                            border: 0;
                            outline: none;
                            background: #707070;
                            border-radius: 50%;
                        }

                        .slick-active button {
                            background: #f3e03a;
                        }

                        .slider--drinks .slider__slide-img {
                            height: 250px !important;
                        }

                        .slider--drinks .slider__slide-text-wrap {
                            padding: 0;
                            background-color: #fff;
                        }

                        .slider--drinks .slider__slide-text-wrap .slider__slide-recipe {
                            padding: 10px 15px;
                        }

                        .slider--drinks .rating__star--active {
                            background-color: #f3e03a;
                        }

                        .slider-quiz .slider__slide-img img:not(.slider-quiz__logo) {
                            border-radius: 25px;
                        }

                        .slider-quiz .slider__slide-img {
                            height: 42.2vh;
                        }

                        .slider-quiz__logo {
                            width: 70%;
                            margin: auto;
                        }

                        .slider__slide--sm .slider__slide-img {
                            height: 160px;
                        }

                        .slider__slide-video {
                            height: 280px;
                            display: -webkit-box;
                            display: -ms-flexbox;
                            display: flex;
                            -webkit-box-pack: end;
                            -ms-flex-pack: end;
                            justify-content: flex-end;
                        }

                        .mobile-preview {
                            display: inline-block;
                            padding: 30px;
                            background: #292929;
                            margin: 20px;
                        }
                    </style>



                    <h4 class="example-title">Preview</h4>
                    <div class="mobile-preview">
                        <div class="slider">
                            <div class="slider-wrap">
                                <div class="slider__slide">
                                    <div class="slider__slide-img">
                                        <img src="{{Storage::url('event-types/'.$event_type->image)}}" alt="" id="image_preview"/>
                                    </div>
                                    <div class="slider__slide-text-wrap">
                                        <h2 class="slider__slide-title" id="title_preview">{{$event_type->title}}</h2>
                                        <span class="slider__slide-text" id="description_preview">{{$event_type->description}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Panel Form Elements -->

        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('input[name ="title"]').keyup(function () {
                var text1 = $(this).val().split(' ');
                if (text1.length > 1) {
                    var span_part = "<span>" + text1[text1.length -1] + "</span>";
                    text1.pop();
                    var rest_part = text1.join(' ');
                    $('#title_preview').html(rest_part + " " + span_part);
                }else {
                    $('#title_preview').html($(this).val());
                }
            });

            $('input[name ="description"]').keyup(function () {
                $('#description_preview').html($(this).val());
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
    </script>
@endsection
