@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{ Breadcrumbs::render('home') }}
                @include('layouts.navbar')

                <div class="card-body">
    
                    <div class="container-fluid">
                        <div class="row">
                            <header class="col-md-12">
                                <nav class="sidebar-sticky bg-light navbar-expand-md">
                                    <h4 class="logo navbar-brand">Быстрые ссылки</h4>
                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                        <ul class="navbar-nav mr-auto flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route("profile") }}" class="nav-link">Ваш профиль</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route("profile.edit") }}" class="nav-link">Настройки профиля</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route("profile.edit.token") }}" class="nav-link">Настройки токена</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route("server") }}" class="nav-link">Список серверов</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route("server.add") }}" class="nav-link">Добавить сервер</a>
                                            </li>
                                        </ul>
                                    </div>
                                </nav>
                            </header>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
