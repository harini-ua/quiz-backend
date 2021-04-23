<style>
    @font-face {
        font-family: 'Hurme Geometric';
        src: local("Hurme Geometric"), url("/assets/fonts/hurmegeometricsans4/hurmegeometricsans4_bold-webfont.woff") format("woff");
        font-weight: bold;
        font-style: normal;
    }

    @font-face {
        font-family: 'Hurme Geometric';
        src: local("Hurme Geometric"), url("/assets/fonts/hurmegeometricsans4/hurmegeometricsans4_light-webfont.woff") format("woff");
        font-weight: 300;
        font-style: normal;
    }

    @font-face {
        font-family: 'Hurme Geometric';
        src: local("Hurme Geometric"), url("/assets/fonts/hurmegeometricsans4/hurmegeometricsans4_semibold-webfont.woff") format("woff");
        font-weight: 500;
        font-style: normal;
    }

    @font-face {
        font-family: 'Hurme Geometric';
        src: local("Hurme Geometric"), url("/assets/fonts/hurmegeometricsans4/hurmegeometricsans4-webfont.woff") format("woff");
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Roboto';
        src: local("Roboto"), url("/assets/fonts/Roboto/Roboto-Regular.woff") format("woff");
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'Roboto';
        src: url("/assets/fonts/Roboto/Roboto-500.woff") format("woff");
        font-weight: bold;
        font-style: normal;
    }

    .body {
        font-family: 'Hurme Geometric', sans-serif;
        margin: 0;
        background: #1c1c1c;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        height: 100vh;
    }

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

    .slider__slide-recipe {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding: 15px;
        text-align: left;
    }

    .slider__slide-recipe__text {
        display: block;
        font-size: 15px;
        color: #1C1C1C;
        max-width: 180px;
        width: 100%;
        margin-right: auto;
        font-weight: bold;
        line-height: 19px;
        overflow-y: auto;
    }

    .slider__slide-recipe__about {
        width: 80px;
        margin-left: 15px;
        color: #1c1c1c;
    }

    .slider__slide-recipe__about-rating {
        margin-bottom: 17px;
    }

    .slider__slide-recipe__about-rating-text {
        display: block;
        margin-bottom: 3px;
        font-size: 10px;
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
    }

    .slider__slide-recipe__about-rating-text--light {
        font-weight: 300;
        margin-top: -9px;
    }

    .slider__slide-recipe__about-rating__stars {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-flex: 0;
        -ms-flex: 0;
        flex: 0;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .slider__slide-recipe__about-rating__star {
        display: inline-block;
        width: 8px;
        height: 8px;
        -ms-flex-negative: 0;
        flex-shrink: 0;
        background-color: #707070;
        border-radius: 50%;
        margin: 0 2.4px;
    }

    .rating__star--active {
        background-color: #fff;
    }

    .slider__slide-recipe__about-time__wrap {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .slider__slide-recipe__about-time__item {
        background-color: #fff;
        border-radius: 6px;
        padding: 5px;
        min-height: 26.6px;
    }

    .slider__slide-recipe__about-time__item:first-child {
        margin-right: 5px;
    }

    .slider__slide-recipe__about-time__item-text {
        display: block;
        font-size: 28px;
        font-weight: bold;
        line-height: 0.6;
    }

    .mobile-preview {
        display: inline-block;
        padding: 30px;
        background: #292929;
        margin: 20px;
    }

    .wrapper-card {
        width: 350px;
    }
</style>

<h3>Preview:</h3>
<div class="mobile-preview">
    <div class="wrapper-card">
        <div class="slider__slide slider__slide--sm {{$type === 'drink'?'slider--drinks':''}}">
            <div class="slider__slide-img">
                <img src="{{$image}}" alt="" id="image_preview"/>
                <span class="slider__slide-img__text" id="title">
                    {{$title}}
                </span>
            </div>
            <div class="slider__slide-text-wrap">
                <div class="slider__slide-recipe">
                    <div class="slider__slide-recipe__text entry-content" id="text">
                        {{$text}}
                    </div>
                    <div class="slider__slide-recipe__about">
                        <div class="slider__slide-recipe__about-rating">
                            <span class="slider__slide-recipe__about-rating-text">Complexity</span>
                            <div class="slider__slide-recipe__about-rating__stars">
                                @for ($i = 0; $i < 5; $i++)
                                    @if($complexity > 0)
                                        <span class="slider__slide-recipe__about-rating__star rating__star--active"></span>
                                        @php($complexity-=1)
                                    @else
                                        <span class="slider__slide-recipe__about-rating__star"></span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="slider__slide-recipe__about-rating">
                            <span class="slider__slide-recipe__about-rating-text">Ingredients</span>
                            <div class="slider__slide-recipe__about-rating__stars">
                                @for ($i = 0; $i < 5; $i++)
                                    @if($ingredients > 0)
                                        <span class="slider__slide-recipe__about-rating__star rating__star--active"></span>
                                        @php($ingredients-=1)
                                    @else
                                        <span class="slider__slide-recipe__about-rating__star"></span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <div class="slider__slide-recipe__about-time">
                            <span class="slider__slide-recipe__about-rating-text">Time</span>
                            <span class="slider__slide-recipe__about-rating-text slider__slide-recipe__about-rating-text--light">(Minutes)</span>
                            <div class="slider__slide-recipe__about-time__wrap" id="minutes_preview">
                                @foreach(str_split($minutes) as $minute)
                                    <div class="slider__slide-recipe__about-time__item">
                                      <span class="slider__slide-recipe__about-time__item-text">
                                        {{ $minute }}
                                      </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

