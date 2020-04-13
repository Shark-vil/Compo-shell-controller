@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{ $request->path() }}</li>
                    </ol>
                </nav>

                <div class="card-header">Профиль</div>

                <div class="card-body">
                    Вы вошли в систему!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
