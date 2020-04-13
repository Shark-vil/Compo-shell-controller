@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @include('layouts.navbar')
                <div class="card-body">
                    <div class="alert alert-info">
                        <a class="btn btn-primary btn-sm btn-default float-right" role="button" href="{{ route('server') }}">Назад</a>
                        <br>
                    </div>

                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                            <td>{{ $log->date }}</td>
                            <td>
                                <a class="btn btn-primary btn-sm btn-default" role="button" href="{{ route('server.logs.date', ['id' => $id, 'date' => $log->date]) }}">Посмотреть историю</a>
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
