@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{ Breadcrumbs::render('profile.edit.token') }}

                <div class="card-body">
                    <div id="alert-block"></div>

                    <form id="id-form-action">
                        <div class="form-group form-control">
                            <input id="id-tokenEternal" class="form-check-input" type="checkbox" value="">
                            <label class="form-check-label" for="id-tokenEternal">Сделать токен вечным?</label>
                        </div>
                        <div class="form-group">
                            <label>Время жизни токена</label>
                            <input id="id-tokenLiveTime" type="datetime-local" class="form-control">
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <a role="button" href="{{ route('profile') }}" class="btn btn-primary">Назад</a>
                            </div>
                            <div>
                                <input type="submit" class="btn btn-primary" value="Добавить"/>
                            </div>
                        </div>
                    </form>

                    <br>

                    <form id="id-form-action-remove">
                        <div class="d-flex justify-content-between">
                            <div></div>
                            <div>
                                <input type="submit" class="btn btn-primary" value="Обнулить токен"/>
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

            $('#id-form-action-remove').on('submit', function(e) {
                e.preventDefault();

                var UserId = {{ $user->id }};

                var SendData = {
                    user_id: UserId,
                    token: "{{ $token }}",
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('api.public-token') }}",
                    data: SendData,
                    success: function(response){
                        AlertIdUpdate();

                        if (response.success) {
                            console.log( "Response: " + response.content );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-success">' +
                            'Токен удалён.' +
                            '</div>');
                        } else {
                            console.error( "Error response: " + response );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-warning">' +
                            'Не удалось удалить токен.' +
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

            $('#id-form-action').on('submit', function(e) {
                e.preventDefault();

                var UserId = {{ $user->id }};
                var TokenEternal = 0;
                var TokenLivesTime = $('#id-tokenLiveTime').val();

                if ($('#id-tokenEternal').is(":checked")) {  
                    TokenEternal = 1;
                }

                var SendData = {
                    user_id: UserId,
                    eternal: TokenEternal,
                    lives_time: TokenLivesTime,
                    token: "{{ $token }}",
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.public-token') }}",
                    data: SendData,
                    success: function(response){
                        AlertIdUpdate();

                        if (response.success) {
                            console.log( "Response: " + response.content );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-success">' +
                            'Токен добавлен.' +
                            '</div>');
                        } else {
                            console.error( "Error response: " + response );

                            $("#alert-block").append('<div id="' + AlertId + '" class="alert alert-warning">' +
                            'Не удалось добавить токен.' +
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