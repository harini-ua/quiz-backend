@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu', [ 'active' => 1])
@endsection

@section('content')
    <div class="page">
        <div class="page-content container-fluid">
            <h4>Hello {{ Auth::user()->name }},</h4>
            <h5>Welcome to administration panel</h5>
        </div>
    </div>
@endsection
