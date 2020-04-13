@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{ Breadcrumbs::render('server.add') }}

                @include('layouts.navbar')

                <div class="card-body">
                    <div id="alert-block"></div>

                    <form id="id-form-action">
                        <div class="form-group">
                            <label>Ip сервера</label>
                            <input id="id-serverip" type="text" class="form-control" required placeholder="Введите ip сервера">
                        </div>
                        <div class="form-group">
                            <label>Port сервера</label>
                            <input id="id-serverPort" name="port" type="number" class="form-control" required placeholder="Введите порт сервера">
                        </div>
                        <div class="form-group">
                            <label>Имя пользователя сервера</label>
                            <input id="id-serverUser" name="user" type="text" class="form-control" required placeholder="Введите имя пользователя сервера">
                        </div>
                        <div class="form-group">
                            <label>Пароль пользователя сервера</label>
                            <input id="id-serverPassword" name="password" type="password" class="form-control" required autocomplete="new-password" placeholder="Введите пароль пользователя сервера">
                            <small class="form-text text-muted">Пароли сервера не выкладываются в общий доступ</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <a role="button" href="{{ route('server') }}" 
                                    class="btn btn-primary">Назад</a>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-primary" value="Добавить"/>
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

            $('#id-form-action').on('submit', function(e) {
                e.preventDefault();

                var serverIp = $("#id-serverip");
                var serverPort = $("#id-serverPort");
                var serverUser = $("#id-serverUser");
                var serverPassword = $("#id-serverPassword");

                var SendData = {
                    ip: serverIp.val(),
                    port: serverPort.val(),
                    user: serverUser.val(),
                    password: serverPassword.val(),
                    token: "{{ $token }}",
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.server') }}",
                    data: SendData,
                    success: function(response){
                        AlertIdUpdate();

                        if (response.success) {
                            console.log( "Response: " + response.content );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-success">' +
                            'Сервер добавлен.' +
                            '</div>');

                            serverIp.val('');
                            serverPort.val('');
                            serverUser.val('');
                            serverPassword.val('');
                        } else {
                            console.error( "Error response: " + response );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-warning">' +
                            'Не удалось добавить сервер.' +
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