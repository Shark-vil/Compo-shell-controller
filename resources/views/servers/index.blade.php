@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Список серверов</div>
                <br>
                <div class="card-body">
                    <div class="alert alert-info">
                        <a class="btn btn-primary btn-sm btn-default float-right" role="button" href="{{ URL::to("/servers/create") }}">Добавить новую запись</a>
                        <br>
                    </div>
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">IP</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($servers as $server)
                            <tr>
                            <td>{{ $server->id }}</td>
                            <td>{{ $server->ip }}</td>
                            <td>{{ $server->user }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Действия
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a role="button" href="{{ URL::to("/servers/console/{$server->id}") }}" class="dropdown-item">Открыть консоль</a>
                                        <a role="button" href="{{ URL::to("/servers/scripts/{$server->id}") }}" class="dropdown-item">Выполнить скрипт</a>
                                        <a role="button" href="{{ URL::to("/servers/change/{$server->id}") }}" class="dropdown-item">Изменить</a>
                                        <a role="button" href="{{ URL::to("/servers/remove/{$server->id}") }}" class="dropdown-item">Удалить</a>
                                    </div>
                                </div>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
