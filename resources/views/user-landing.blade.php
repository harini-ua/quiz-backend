@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    <ul class="site-menu" data-plugin="menu">
        <li class="site-menu-category">General</li>
        <li class="site-menu-item active">
            <a href="#">
                <i class="site-menu-icon fas fa-home wb-dashboard"></i>
                <span class="site-menu-title">Home</span>
            </a>
        </li>
        <li class="site-menu-item">
            <a href="#">
                <i class="site-menu-icon fas fa-users wb-dashboard"></i>
                <span class="site-menu-title">Users</span>
            </a>
        </li>
        <li class="site-menu-item">
            <a href="#">
                <i class="site-menu-icon fas fa-calendar-week wb-dashboard"></i>
                <span class="site-menu-title">Event Types</span>
            </a>
        </li>
        <li class="site-menu-item">
            <a href="#" target="_blank">
                <i class="site-menu-icon fas fa-utensils wb-dashboard"></i>
                <span class="site-menu-title">Food types</span>
            </a>
        </li>
        <li class="site-menu-item">
            <a href="#" target="_blank">
                <i class="site-menu-icon fas fa-cocktail wb-dashboard"></i>
                <span class="site-menu-title">Drink types</span>
            </a>
        </li>
        <li class="site-menu-item">
            <a href="#" target="_blank">
                <i class="site-menu-icon fas fa-question-circle wb-dashboard"></i>
                <span class="site-menu-title">Quiz questions</span>
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <div class="page">
        <div class="page-content container-fluid">
            <h4>
                Hello {{ Auth::user()->name }},
            </h4>
            <h4>
                You are regular user right now and you don't have access to administration panel
            </h4>
        </div>
    </div>
@endsection
