@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    <ul class="site-menu" data-plugin="menu">
        <li class="site-menu-category">General</li>
        <li class="site-menu-item active">
            <a href="{{ route('admin-home') }}">
                <i class="site-menu-icon fas fa-home wb-dashboard"></i>
                <span class="site-menu-title">Home</span>
            </a>
        </li>
        <li class="site-menu-item">
            <a href="{{ route('users.index') }}">
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
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Event Types</li>
            </ol>
            <h1 class="page-title">Event Types</h1>
            <div class="page-header-actions">
                <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                        data-original-title="Edit">
                    <i class="icon wb-pencil" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                        data-original-title="Refresh">
                    <i class="icon wb-refresh" aria-hidden="true"></i>
                </button>
                <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                        data-original-title="Setting">
                    <i class="icon wb-settings" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content container-fluid">
            <!-- Example Card Base -->
            <div class="example-wrap">
                <h3 class="example-title">Base</h3>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <img class="card-img-top img-fluid w-full" src="{{ asset('assets/images/login.jpg') }}"
                                 alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                        <!-- End Example Standard Card -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <img class="card-img-top img-fluid w-full" src="{{ asset('assets/images/login.jpg') }}"
                                 alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                        <!-- End Example Standard Card -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card">
                            <img class="card-img-top img-fluid w-full" src="{{ asset('assets/images/login.jpg') }}"
                                 alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                        <!-- End Example Standard Card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <!-- Example Card Image overlays -->
                        <div class="card card-inverse">
                            <img class="card-img w-full" src="{{ asset('assets/images/login.jpg') }}" alt="Card image">
                            <div class="card-img-overlay">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content.</p>
                            </div>
                        </div>
                        <!-- End Example Card Image overlays -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <!-- Example Card Image overlays -->
                        <div class="card card-inverse">
                            <img class="card-img w-full" src="{{ asset('assets/images/login.jpg') }}" alt="Card image">
                            <div class="card-img-overlay">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content.</p>
                            </div>
                        </div>
                        <!-- End Example Card Image overlays -->
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <!-- Example Card Image overlays -->
                        <div class="card card-inverse">
                            <img class="card-img w-full" src="{{ asset('assets/images/login.jpg') }}" alt="Card image">
                            <div class="card-img-overlay">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">This is a wider card with supporting text below as a natural
                                    lead-in to additional content.</p>
                            </div>
                        </div>
                        <!-- End Example Card Image overlays -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <h4 class="example-title">Types</h4>
                        <div class="card">
                            <img class="card-img-top img-fluid w-full" src="{{ asset('assets/images/login.jpg') }}"
                                 alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up
                                    the bulk of the card's content.</p>
                            </div>
                            <ul class="list-group list-group-dividered px-20 mb-0">
                                <li class="list-group-item px-0">Cras justo odio</li>
                                <li class="list-group-item px-0">Dapibus ac facilisis in</li>
                                <li class="list-group-item px-0">Vestibulum at eros</li>
                            </ul>
                            <div class="card-block">
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <h4 class="example-title">Types</h4>
                        <div class="card">
                            <img class="card-img-top img-fluid w-full" src="{{ asset('assets/images/login.jpg') }}"
                                 alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up
                                    the bulk of the card's content.</p>
                            </div>
                            <ul class="list-group list-group-dividered px-20 mb-0">
                                <li class="list-group-item px-0">Cras justo odio</li>
                                <li class="list-group-item px-0">Dapibus ac facilisis in</li>
                                <li class="list-group-item px-0">Vestibulum at eros</li>
                            </ul>
                            <div class="card-block">
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <h4 class="example-title">Types</h4>
                        <div class="card">
                            <img class="card-img-top img-fluid w-full" src="{{ asset('assets/images/login.jpg') }}"
                                 alt="Card image cap">
                            <div class="card-block">
                                <h4 class="card-title">Card title</h4>
                                <p class="card-text">Some quick example text to build on the card title and make up
                                    the bulk of the card's content.</p>
                            </div>
                            <ul class="list-group list-group-dividered px-20 mb-0">
                                <li class="list-group-item px-0">Cras justo odio</li>
                                <li class="list-group-item px-0">Dapibus ac facilisis in</li>
                                <li class="list-group-item px-0">Vestibulum at eros</li>
                            </ul>
                            <div class="card-block">
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
@endsection
