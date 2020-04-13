@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @include('layouts.navbar')
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Результат:</label>
                        <textarea readonly class="form-control" rows="10" id="textarea_console_log"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Команда:</label>
                        <input type="text" class="form-control" id="input_console_command" placeholder="Введите консольную команду">
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <a role="button" href="{{ route('server') }}" class="btn btn-primary">Назад</a>
                        </div>
                        <div>
                            <input id="id-send-console-command" type="button" id="id-send-button" class="btn btn-primary" value="Отправить"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var CommandHistory = [];
            var CommandHistoryIndex = -1;

            var TextareaConsoleLog = $("#textarea_console_log");
            var InputConsoleCommand = $("#input_console_command");
            
            var ServerId = '{{ $server->id }}';
            var ServerIp = '{{ $server->ip }}';
            var ServerPort = '{{ $server->port }}';
            var ServerUser = '{{ $server->user }}';
            var ServerPassword = '{{ $server->password }}';
            var ApiToken = '{{ $token }}';

            TextareaConsoleLog.val("Выбран сервер - " + ServerIp + ":" + ServerPort + " под пользователем " + ServerUser + "\n");

            function ScrollTop() {
                if(TextareaConsoleLog.length)
                    TextareaConsoleLog.scrollTop(TextareaConsoleLog[0].scrollHeight - TextareaConsoleLog.height());
            }

            function SendConsoleCommand(TextCommand) {
                var IsClear = false;
                var IsResult = false;

                if ($.trim(TextCommand) == "clear") {
                    IsClear = true;
                }

                var DataSend = {
                    id: ServerId,
                    ip: ServerIp,
                    port: ServerPort,
                    user: ServerUser,
                    password: ServerPassword,
                    command: TextCommand,
                    token: ApiToken,
                    _token: "{{ csrf_token() }}"
                };

                if (IsClear) {
                    TextareaConsoleLog.val('');
                }

                var TextareaOldValue = TextareaConsoleLog.val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('api.shell.exec') }}",
                    data: DataSend,
                    success: function(response){
                        if (response.success) {
                            console.log( "Response: " + response.content );

                            if (!IsClear) {
                                TextareaConsoleLog.val(TextareaOldValue + "Response (" + response.success + "): \n> " + response.content);
                            }
                        } else {
                            console.error( "Error response: " + response );

                            if (!IsClear) {
                                TextareaConsoleLog.val(TextareaOldValue + "Error response (" + response.success + "): \n> " + response.content + "\n");
                            }
                        }

                        ScrollTop();
                    },
                    error: function(response){
                        console.error( "Error request: " + response );
                        if (response.content == undefined) {
                            TextareaConsoleLog.val(TextareaOldValue + "Error request (false): \n> There is no connection to the server.\n");
                        } else {
                            TextareaConsoleLog.val(TextareaOldValue + "Error request (false): \n> " + response.content + "\n");
                        }
                    }
                });
            }

            function GetAndSendCommand() {
                var TextCommand = InputConsoleCommand.val();

                if ($.trim(TextCommand) != '') {
                    CommandHistory.push(TextCommand);
                    CommandHistoryIndex = CommandHistory.length;
                }

                SendConsoleCommand(TextCommand);
                InputConsoleCommand.val('');
            }

            $("#id-send-console-command").click(function(e) {
                GetAndSendCommand();
            });

            InputConsoleCommand.keyup(function(e) {
                if(e.keyCode == 13) {
                    GetAndSendCommand();
                }

                if (e.keyCode == 38) {
                    if (CommandHistoryIndex >= 0 ) {
                        InputConsoleCommand.val(CommandHistory[CommandHistoryIndex]);
                    } else {
                        InputConsoleCommand.val('');
                        CommandHistoryIndex = -1;
                    }

                    CommandHistoryIndex--;

                    if (CommandHistoryIndex < -1) {
                        CommandHistoryIndex = -1;
                    }
                }

                if (e.keyCode == 40) {
                    CommandHistoryIndex++;

                    if (CommandHistoryIndex > CommandHistory.length) {
                        CommandHistoryIndex = CommandHistory.length;
                    }

                    if (CommandHistoryIndex <= CommandHistory.length) {
                        InputConsoleCommand.val(CommandHistory[CommandHistoryIndex]);
                    }
                }
            });
        });
    </script>
@endsection
