jQuery(document).ready(function (){
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    jQuery('select#payment_method').on('change', function (){
        let select = jQuery(this);
        if(select.val() != 'xyz')
            jQuery('.firstname').hide();
        else
            jQuery('.firstname').show();
        if(select.val() == 'qwerty'){
            jQuery('.multi-currency').show().addClass('active');
            jQuery('.rub-currency').hide();
        } else {
            jQuery('.multi-currency').hide().removeClass('active');
            jQuery('.rub-currency').show();
        }
        changeCurrency();
        jQuery('.error-input').hide();
    });
    jQuery('select.multi-currency').on('change', function (){
        changeCurrency();
    });
    jQuery('.amount').on('input', function (){changeCurrency();});
    jQuery('.sendPay').on('click', function (){
        let self = jQuery(this);
        self.prop('disabled', true);
        if(jQuery('.amount').val() <= 0){
            jQuery('.error-amount').text('Укажите сумму пополнения').show();
            self.prop('disabled', false);
        }
        let code = (jQuery('.multi-currency').hasClass('active')) ?  jQuery('select.multi-currency').val() : 'RUB',
            method = jQuery('select#payment_method').val(),
            amount = jQuery('.amount').val();
        sendPay(code, method, amount);
    });

    function changeCurrency(){
        let code = (jQuery('.multi-currency').hasClass('active')) ?  jQuery('select.multi-currency').val() : 'RUB',
            amount = jQuery('.amount').val();
        if(code == 'RUB'){
            jQuery('#rate_currency').text('');
            return;
        }
        getRateCurrency(code, amount);
    }

    function getRateCurrency(code, amount = 1){
        amount = !amount ? 1 : amount;
        let url = '/paymentmodule/getRateCurrency',
            params = jQuery.param({code:code, amount: amount});

        jQuery.get(url+'?'+params,function (data){
            if(data.status && data.rate_amount){
                jQuery('#rate_currency').text('Курс '+amount+' '+code+' = '+data.rate_amount+' RUB');
            } else {
                jQuery('#rate_currency').text('Сервис конвентирования не данный момент не доступен');
            }
        });
    }

    function sendPay(code, method, amount){
        let error_input = jQuery('.error-amount'), name = jQuery('input#name').val();
        error_input.hide();
        if(!amount) {
            error_input.text('Укажите сумму пополнения').show();
            return false;
        }
        if(!method){
            error_input.text('Выберите сервис для пополнения баланса').show();
            return false;
        }
        if(!code){
            error_input.text('Укажите валюту').show();
            return false;
        }
        let data = {code:code, method: method, amount: amount, name: name};
        jQuery.ajax({
            url: '/paymentmodule/sendPay',
            method: 'POST',
            data: data,
            success:function (data){
                if(data == 'error'){
                    jQuery('.payment_success').arcticmodal({
                        beforeOpen: function(){
                            jQuery('.payment_success').show();
                            jQuery('.payment_success_video').get(0).play();
                        },
                        afterClose: function () {
                            jQuery('.payment_success').hide();
                        }
                    });
                }
                jQuery('.sendPay').prop('disabled', false);
            }
        });
    }
});
