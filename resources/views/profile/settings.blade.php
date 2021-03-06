@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{ Breadcrumbs::render('profile.edit') }}
                
                <div class="card-header">Обновление информации профиля</div>

                <div class="card-body">
                    <div id="alert-block"></div>

                    <form id="id-form-action">
                        <div class="form-group">
                            <label>Имя пользователя</label>
                            <input id="id-userName" type="text" class="form-control" required placeholder="Введите имя пользователя" value="{{ $user->name }}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <a role="button" href="{{ route('profile') }}" 
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

                var userName = $("#id-userName");

                var SendData = {
                    name: userName.val(),
                    token: "{{ $token }}",
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    type: "PUT",
                    url: "{{ route('api.profile') }}",
                    data: SendData,
                    success: function(response){
                        AlertIdUpdate();

                        if (response.success) {
                            console.log( "Response: " + response.content );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-success">' +
                            'Данные профиля обновлены.' +
                            '</div>');
                        } else {
                            console.error( "Error response: " + response );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-warning">' +
                            'Не удалось обновить данные профиля.' +
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