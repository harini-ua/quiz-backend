@extends('layouts.template')

@section('head-title')
    Liqor43 | Admin panel
@endsection

@section('menu')
    @include('partials.menu', ['active' => 2])
@endsection

@section('content')
    <div class="page">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">All users</li>
            </ol>
            <h1 class="page-title">Registered users</h1>
            <div class="page-header-actions">
                <a href="{{ route('users.download-csv') }}">
                    <button type="button" class="btn btn-sm btn-icon btn-inverse btn-round" data-toggle="tooltip"
                            data-original-title="Download as CSV Excel file">
                        <i class="icon wb-download" aria-hidden="true"></i>
                    </button>
                </a>
            </div>
        </div>
        <!-- Page Content -->
        <div class="page-content container-fluid">
            <div class="example-wrap">
                <div class="row">
                    @foreach($users as $user)
                        <div class="col-lg-2 col-md-6">
                            <div class="card">
                                <img class="card-img-top img-fluid w-full" src="{{ asset('assets/images/liqor_logo.png') }}"
                                     alt="Card image cap">
                                <div class="card-block">
                                    <h4 class="card-title">{{ $user->name }}</h4>
                                    <p class="card-text">{{ $user->email }}</p>
                                    <p class="card-text">Registered: {{ $user->created_at->format('d/m/Y') }}</p>
                                    @if ($user->password === 'fb-login')
                                        <p class="card-text">Facebook User</p>
                                    @else
                                        <p class="card-text">Licor43 User</p>
                                    @endif

                                    @if ($user->is_admin)
                                        <p class="card-text">This user is ADMINISTRATOR</p>
                                        {{--@if (Auth::user()->id !== $user->id)--}}
                                        <a href="{{ route('users.remove-admin') }}" class="btn btn-danger"
                                           onclick="event.preventDefault();document.getElementById('admin-form{{ $user->id }}').submit();">Remove
                                            admin privilege</a>

                                        <form id="admin-form{{ $user->id }}" action="{{ route('users.remove-admin') }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                        </form>
                                        {{--@endif--}}
                                    @else
                                        <p class="card-text">This is regular user</p>
                                        <a href="{{ route('users.set-admin') }}" class="btn btn-primary"
                                           onclick="event.preventDefault();document.getElementById('admin-form{{ $user->id }}').submit();">Set
                                            as admin</a>
                                        <form id="admin-form{{ $user->id }}" action="{{ route('users.set-admin') }}"
                                              method="POST"
                                              style="display: none;">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                        </form>
                                    @endif
                                    <a href="{{ route('users.test-broadcast') }}" class="btn btn-primary"
                                       onclick="event.preventDefault();document.getElementById('broadcast{{ $user->id }}').submit();">Send
                                        notification</a>
                                    <form id="broadcast{{ $user->id }}" action="{{ route('users.test-broadcast') }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                    </form>
                                    <a href="{{route('users.destroy', ['user' => $user->id])}}"
                                       onclick="event.preventDefault();document.getElementById('delete{{ $user->id }}').submit();">
                                        <button type="button"
                                                class="btn btn-sm btn-icon btn-inverse btn-round"
                                                data-toggle="tooltip"
                                                data-original-title="Delete">
                                            <i class="icon wb-trash" aria-hidden="true"></i>
                                        </button>
                                    </a>
                                    <form id="delete{{ $user->id }}"
                                          action="{{ route('users.destroy', ['user' => $user->id]) }}"
                                          method="POST"
                                          style="display: none;">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End Page Content -->
    </div>
@endsection
