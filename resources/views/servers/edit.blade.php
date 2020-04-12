@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @include('layouts.navbar')
                
                <div class="card-header">Обновление информации сервера</div>

                <div class="card-body">
                    <div id="alert-block"></div>

                    <form>
                        <div class="form-group">
                            <label>Ip сервера</label>
                            <input id="id-serverip" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Введите ip сервера" value="{{ $server->ip }}">
                        </div>
                        <div class="form-group">
                            <label>Port сервера</label>
                            <input id="id-serverPort" name="port" type="number" class="form-control" placeholder="Введите порт сервера" value="{{ $server->port }}">
                        </div>
                        <div class="form-group">
                            <label>Имя пользователя сервера</label>
                            <input id="id-serverUser" name="user" type="text" class="form-control" placeholder="Введите имя пользователя сервера" value="{{ $server->user }}">
                        </div>
                        <div class="form-group">
                            <label>Пароль пользователя сервера</label>
                            <input id="id-serverPassword" name="password" type="password" class="form-control" placeholder="Введите пароль пользователя сервера">
                            <small class="form-text text-muted">Пароли сервера не выкладываются в общий доступ</small>
                        </div>
                        <input name="token" type="hidden" class="form-control" value="{{ $token }}">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a role="button" href="{{ route('servers') }}" 
                                    class="btn btn-primary">Назад</a>
                            </div>
                            <div>
                                <input type="button" id="id-send-button" class="btn btn-primary" value="Обновить"/>
                            </div>
                        </div>
                    </form>
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

            $("#id-send-button").click(function(e) {
                var serverIp = $("#id-serverip");
                var serverPort = $("#id-serverPort");
                var serverUser = $("#id-serverUser");
                var serverPassword = $("#id-serverPassword");

                var SendData = {
                    id: {{ $server->id }},
                    ip: serverIp.val(),
                    port: serverPort.val(),
                    user: serverUser.val(),
                    password: serverPassword.val(),
                    token: "{{ $token }}",
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    type: "PUT",
                    url: "{{ route('api.servers') }}",
                    data: SendData,
                    success: function(response){
                        AlertIdUpdate();

                        if (response.success) {
                            console.log( "Response: " + response.content );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-success">' +
                            'Данные сервера обновлены.' +
                            '</div>');
                        } else {
                            console.error( "Error response: " + response );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-warning">' +
                            'Не удалось обновить данные сервера.' +
                            '</div>');
                        }
                        
                        AlertFade();
                    },
                    error: function(response){
                        AlertIdUpdate();

                        console.error( "Error request: " + response );

                        $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-danger">' +
                        'Ошибка отправки запроса.' +
                        '</div>');

                        AlertFade();
                    }
                });
            });
        });
    </script>
@endsection