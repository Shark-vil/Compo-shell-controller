@extends('layouts.app')

@section('styles')
   
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                {{ Breadcrumbs::render('profile') }}

                @include('layouts.navbar')

                <div class="card-body">
                    
                    <div class="container">

                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    <img width="150px" height="150px" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" class="rounded-circle">
                                </div>
                                <div class="col-md-4">
                                    <h4>Информация об аккаунте</h4>
                                    <p class="font-weight-bold">Имя: <span class="font-weight-normal">{{ $user->name }}</span></p>
                                    <p class="font-weight-bold">Почта: <a class="btn btn-default btn-sm" href = "mailto:{{ $user->email }}">{{ $user->email }}</a></span></p>
                                    <p class="font-weight-bold">Должность: <span class="font-weight-normal">Сотрудник</span></p>
                                    <p class="font-weight-bold">Приватный токен: <span class="font-weight-normal">Сотрудник</span></p>
                                    <a class="btn btn-danger btn-sm" data-toggle="collapse" href="#id-private-token" role="button" aria-expanded="false" aria-controls="id-private-token">Посмотреть приватный токен</a>

                                    <div class="collapse" id="id-private-token">
                                        <div class="mt-3">
                                            <div class="panel panel-default">
                                                <div class="panel-body">{{ $token }}</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
