@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @include('layouts.navbar')
                <div class="card-body">
                    <div class="alert alert-info">
                        <a class="btn btn-primary btn-sm btn-default float-right" role="button" href="{{ route('server.logs', ['id' => $id]) }}">Назад</a>
                        <br>
                    </div>

                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                            <th scope="col">Время</th>
                            <th scope="col">Команда</th>
                            <th scope="col">Результат</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                            <td>{{ $log->time }}</td>
                            <td>{{ $log->command }}</td>
                            <td><textarea readonly class="form-control" rows="2">{{ $log->result }}</textarea></td>
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
