@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @include('layouts.navbar')
                <div class="card-body">
                    <div class="alert alert-info">
                        <a class="btn btn-primary btn-sm btn-default float-right" role="button" href="{{ URL::to("/servers/add") }}">Добавить новую запись</a>
                        <br>
                    </div>
                    
                    <div id="alert-block"></div>

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
                                        <a role="button" href="{{ URL::to("/servers/logs/{$server->id}") }}" class="dropdown-item">Лог</a>
                                        <a role="button" href="{{ URL::to("/servers/edit/{$server->id}") }}" class="dropdown-item">Изменить</a>
                                        <a id="id-delete" data-id="{{ $server->id }}" role="button" href="#" class="dropdown-item">Удалить</a>
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

@section('javascripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var AlertIndex = 0;
            var AlertId;

            function AlertIdUpdate() {
                AlertId = 'alert-' + AlertIndex;
                AlertIndex++;
            }

            function AlertFade() {
                var DelayTime = 3500;
                var AlertBlock = $('#' + AlertId);
                AlertBlock.fadeIn().delay(DelayTime).fadeOut();
                setTimeout(function() {
                    AlertBlock.remove();
                }, DelayTime + 1500);
            }

            $('[id^="id-delete"]').click(function(e) {
                var MainA = $(this);

                $.confirm({
                    title: 'Удаление сервера.',
                    content: 'Вы действительно хотите удалить сервер?',
                    buttons: {
                        Да: function () {
                            var SendData = {
                                id: MainA.data("id"),
                                token: "{{ $token }}",
                                _token: "{{ csrf_token() }}"
                            };
                            
                            $.ajax({
                                type: "DELETE",
                                url: "{{ route('api.servers') }}",
                                data: SendData,
                                success: function(response){
                                    AlertIdUpdate();

                                    if (response.success) {
                                        console.log( "Response: " + response.content );

                                        $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-success">' +
                                        'Сервер удалён.' +
                                        '</div>');

                                        MainA.parent().parent().parent().parent().remove();
                                    } else {
                                        console.error( "Error response: " + response );

                                        $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-warning">' +
                                        'Не удалось удалить сервер.' +
                                        '</div>');
                                    }
                                    
                                    AlertFade();
                                },
                                error: function(response){
                                    AlertIdUpdate();

                                    console.error( "Error request: " + response );

                                    $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-danger">' +
                                    'Ошибка отрпавки запроса.' +
                                    '</div>');

                                    AlertFade();
                                }
                            });
                        },
                        Нет: function () {},
                    }
                });
            });
        });
    </script>
@endsection
