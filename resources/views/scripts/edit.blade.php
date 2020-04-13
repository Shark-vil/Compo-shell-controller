@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{ Breadcrumbs::render('server.scripts.edit', $server_id, $script->id) }}

                @include('layouts.navbar')

                <div class="card-body">
                    <div id="alert-block"></div>

                    <form id="id-form-action">
                        <div class="form-group">
                            <label>Описание команды</label>
                            <input id="id-commandDesc" type="text" class="form-control" required placeholder="Введите описание команды" value="{{ $script->description }}">
                        </div>
                        <div class="form-group">
                            <label>Команда</label>
                            <input id="id-command" name="port" type="text" class="form-control" required placeholder="Введите команду" value="{{ $script->command }}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <a role="button" href="{{ route('server.scripts', $server_id) }}" 
                                    class="btn btn-primary">Назад</a>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-primary" value="Обновить"/>
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

                var serverCommandDesc = $("#id-commandDesc");
                var serverCommand = $("#id-command");

                var SendData = {
                    id: {{ $script->id }},
                    server_id: {{ $server_id }},
                    description: serverCommandDesc.val(),
                    command: serverCommand.val(),
                    token: "{{ $token }}",
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    type: "PUT",
                    url: "{{ route('api.server.script') }}",
                    data: SendData,
                    success: function(response){
                        AlertIdUpdate();

                        if (response.success) {
                            console.log( "Response: " + response.content );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-success">' +
                            'Команда добавлена.' +
                            '</div>');
                        } else {
                            console.error( "Error response: " + response );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-warning">' +
                            'Не удалось добавить команду.' +
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