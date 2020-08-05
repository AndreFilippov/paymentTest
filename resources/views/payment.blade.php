@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Пополнить баланс') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-md-8 offset-md-2">
                            <form class="payment_form">
                                <div class="form-group">
                                    <label for="payment_method">Метод оплаты</label>
                                    <select class="form-control" id="payment_method">
                                        <option value="xyz">XYZPayment’s</option>
                                        <option value="qwerty">QWERTY-Kassa</option>
                                        <option value="oldpay">OLDPay</option>
                                    </select>
                                </div>
                                <div class="payment_method">
                                    <div class="form-group firstname">
                                        <label for="name">Имя плательщика</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Имя плательщика" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Сумма пополнения</label>
                                        <div class="input-group mb-3">
                                            <label for="amount"></label><input type="number" class="form-control amount" name="amount" placeholder="Сумма пополнения" aria-describedby="basic-addon2" required>
                                            <div class="input-group-append">
                                                <select class="form-control input-group-text multi-currency" style="display: none;">
                                                    <option value="USD">USD</option>
                                                    <option value="EUR">EUR</option>
                                                    <option selected value="RUB">RUB</option>
                                                    <option value="UAH">UAH</option>
                                                </select>
                                                <div class="input-group-append rub-currency">
                                                    <span class="input-group-text" id="basic-addon2">RUB</span>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="form-text error-text error-input error-amount"></small>
                                        <small id="rate_currency" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <button type="button" class="sendPay btn btn-outline-success">Пополнить баланс</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="payment_success" style="display: none">
        <video class="payment_success_video">
            <source src="{{asset('/img/payment_success.mp4')}}" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
        </video>
    </div>
    <div class="payment_fail">

    </div>
    <script src="{{asset('/js/jquery.arcticmodal-0.3.min.js')}}"></script>
    <script src="{{asset('/js/payment.js')}}"></script>
@endsection
