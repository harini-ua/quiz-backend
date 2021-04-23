@extends('layouts.sign-up-template')

@section('head-title')
    Liqor43 | Register
@endsection

@section('body-classes')
    page-register-v2
@endsection

@section('content')
    <div class="page" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content">
            <div class="page-brand-info">
                <div class="brand">
                    <img class="brand-img" src="/assets/images/liqor.png" alt="...">
                    <h2 class="brand-text font-size-40">Liqor43</h2>
                </div>
                <p class="font-size-20">Welcome to registration for administrators</p>
            </div>
            <div class="page-register-main animation-slide-left animation-duration-1">
                <div class="brand hidden-md-up">
                    <img class="brand-img" src="/assets/images/liqor.png" alt="...">
                    <h3 class="brand-text font-size-40">Liqor43</h3>
                </div>
                <h3 class="font-size-24">Sign Up</h3>
                <p>This is registration for administrators</p>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only" for="inputName">Full Name</label>
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" value="{{ old('name') }}">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password"
                               placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="inputPasswordCheck">Retype Password</label>
                        <input type="password" class="form-control" id="inputPasswordCheck" name="password_confirmation"
                               placeholder="Confirm Password">
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
                    <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                </form>
                <p>Have account already? Please go to <a href="{{route('login')}}">Sign In</a></p>
                <footer class="page-copyright">
                    <p>Liqor43</p>
                    <p>© {{ \Carbon\Carbon::now()->format('Y') }}. All RIGHT RESERVED.</p>
                    <div class="social">
                        <a class="btn btn-icon btn-round social-twitter mx-5" href="javascript:void(0)">
                            <i class="icon bd-twitter" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-round social-facebook mx-5" href="javascript:void(0)">
                            <i class="icon bd-facebook" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-icon btn-round social-google-plus mx-5" href="javascript:void(0)">
                            <i class="icon bd-google-plus" aria-hidden="true"></i>
                        </a>
                    </div>
                </footer>
            </div>
        </div>
    </div>
@endsection
