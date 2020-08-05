@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-md-8">
                            <p>Имя: {{$user->name}}</p>
                            <p>Email: {{$user->email}}</p>
                            <p>Баланс: {{$user->balance}} RUB</p>
                            <a class="btn btn-primary" href="/balance" role="button">Пополнить баланс</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
