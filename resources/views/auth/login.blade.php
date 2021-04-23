@extends('layouts.sign-up-template')

@section('head-title')
    Liqor43 | Login
@endsection

@section('body-classes')
    page-login-v2
@endsection

@section('content')
    <style>
        body {
            background: transparent;
        }
    </style>
    <!-- Page -->
    <div class="page" data-animsition-in="fade-in" data-animsition-out="fade-out">
        <div class="page-content">
            <div class="page-brand-info">
                <div class="brand">
                    <img class="brand-img" src="/assets/images/liqor.png" alt="...">
                    <h2 class="brand-text font-size-40">Liqor43</h2>
                </div>
                <p class="font-size-20">Welcome to login for administrators</p>
            </div>
            <div class="page-login-main animation-slide-right animation-duration-1">
                <div class="brand hidden-md-up">
                    <img class="brand-img" src="../../assets/images/logo-colored@2x.png" alt="...">
                    <h3 class="brand-text font-size-40">Remark</h3>
                </div>
                <h3 class="font-size-24">Sign In</h3>
                <p>Login to get in administration panel</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only" for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="inputPassword">Password</label>
                        <input type="password" class="form-control" id="inputPassword" name="password"
                               placeholder="Password">
                    </div>
                    <div class="form-group clearfix">
                        <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Remember me</label>
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
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                </form>
                <p>No account? <a href="{{route('register')}}">Sign Up</a></p>
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
    <!-- End Page -->
@endsection
