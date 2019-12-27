<div class="error-message" id="error-message" role="alert" style="display: none;">
    <strong>Error!</strong>
    <span></span>
</div>
<form class="online_payment" action="<?php echo route('postCreateOrder', ['event_id' => $event->id]); ?>" method="post" id="square-checkout-payment-form">
    <div class="form-row">
        <div class="row square-logo">
            <img class="col-sm-12 col-sm-offset-0" src="{{asset('assets/images/public/EventPage/square-credit-cards.png')}}"/>
        </div>

        <div id="form-container">
            <div id="sq-card"></div>
            <button id="sq-creditcard" class="btn button-credit-card" onclick="onGetCardNonce(event)">
                <div class="la-ball-scale-ripple-multiple" id="loader-icon" style="display:none;">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <span id="button-label">Pay {{  $orderService->getGrandTotal(true) }}</span>
            </button>
        </div>
    </div>
    {!! Form::token() !!}
    {!! Form::hidden('card_nonce', '', ['id' => 'card_nonce']) !!}
</form>

<script type="text/javascript" src="https://js.squareupsandbox.com/v2/paymentform">
</script>

<script type="text/javascript">
    let payButton = document.getElementById("sq-creditcard");
    let buttonLabel = document.getElementById("button-label");
    let loaderIcon = document.getElementById("loader-icon");

    function enableButton() {
        buttonLabel.textContent = 'Pay {{  $orderService->getGrandTotal(true) }}';
        loaderIcon.style = 'display:none;'
        payButton.disabled = false;
    }
    function disableButton() {
        buttonLabel.textContent = 'Loading...';
        loaderIcon.style = 'display:block-inline;'
        payButton.disabled = true;
    }

    // Create and initialize a payment form object
    const paymentForm = new SqPaymentForm({
    // Initialize the payment form elements

    applicationId: '<?php echo $account_payment_gateway->config['appId']; ?>',
    autoBuild: false,
    // Initialize the credit card placeholders
        card: {
        elementId: 'sq-card',
        },
    // SqPaymentForm callback functions
    callbacks: {
        /*
        * callback function: cardNonceResponseReceived
        * Triggered when: SqPaymentForm completes a card nonce request
        */
        cardNonceResponseReceived: function (errors, nonce, cardData) {
                if (errors) {
                    // Log errors from nonce generation to the browser developer console.
                    console.error('Encountered errors:');
                    errors.forEach(function (error) {
                        console.error('  ' + error.message);
                    });
                    return;
                }

                $("#card_nonce").val(nonce);

                var form = $("#square-checkout-payment-form")
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    success: function(data)
                    {
                        if(data['redirectUrl']) {
                            window.location.replace(data['redirectUrl']);
                        }
                        if(data['status'] == 'error') {
                            $("#error-message span").html(data['message']);
                            $("#error-message").show();
                            enableButton();
                        }
                    }
                });
        }
    }
    });

    paymentForm.build();

    // onGetCardNonce is triggered when the "Pay" button is clicked
    function onGetCardNonce(event) {
        // Don't submit the form until SqPaymentForm returns with a nonce
        event.preventDefault();
        disableButton();
        $("#error-message").hide();
        // Request a nonce from the SqPaymentForm object
        paymentForm.requestCardNonce();
    }
   </script>


   <style>
        /*
        Copyright 2019 Square Inc.
        Licensed under the Apache License, Version 2.0 (the "License");
        you may not use this file except in compliance with the License.
        You may obtain a copy of the License at
            http://www.apache.org/licenses/LICENSE-2.0
        Unless required by applicable law or agreed to in writing, software
        distributed under the License is distributed on an "AS IS" BASIS,
        WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
        See the License for the specific language governing permissions and
        limitations under the License.
        */

        * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        }

        body, html {
        background-color: #F7F8F9;
        color: #373F4A;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        font-weight: normal;
        height: 100%;
        }

        button {
        border: 0;
        font-weight: 500;
        }

        fieldset {
        margin: 0;
        padding: 0;
        border: 0;
        }

        #form-container {
        position: relative;
        width: 380px;
        margin: 0 auto;
        top: 50%;
        }


        /* Customize the "Pay with Credit Card" button */
        .button-credit-card {
            width: 100%;
            height: 56px;
            margin-top: 10px;
            background: #4A90E2;
            border-radius: 6px;
            cursor: pointer;
            display: block;
            color: #FFFFFF;
            font-size: 16px;
            line-height: 24px;
            font-weight: 700;
            letter-spacing: 0;
            text-align: center;
            -webkit-transition: background .2s ease-in-out;
                -moz-transition: background .2s ease-in-out;
                -ms-transition: background .2s ease-in-out;
                    transition: background .2s ease-in-out;

            display: flex;
            justify-content: center;
            align-items: center;
        }

        .button-credit-card:hover {
        background-color: #4281CB;
        }



        .square-logo {
            margin:40px;
        }

        .error-message {
            padding: 15px;
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        /*!
        * Load Awesome v1.1.0 (http://github.danielcardoso.net/load-awesome/)
        * Copyright 2015 Daniel Cardoso <@DanielCardoso>
        * Licensed under MIT
        */
        .la-ball-scale-ripple-multiple,
        .la-ball-scale-ripple-multiple > div {
            position: relative;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
                    box-sizing: border-box;
        }
        .la-ball-scale-ripple-multiple {
            display: inline-block;
            margin-right: 10px;
            font-size: 0;
            color: #fff;
        }
        .la-ball-scale-ripple-multiple.la-dark {
            color: #333;
        }
        .la-ball-scale-ripple-multiple > div {
            display: inline-block;
            float: none;
            background-color: currentColor;
            border: 0 solid currentColor;
        }
        .la-ball-scale-ripple-multiple {
            width: 32px;
            height: 32px;
        }
        .la-ball-scale-ripple-multiple > div {
            position: absolute;
            top: 0;
            left: 0;
            width: 32px;
            height: 32px;
            background: transparent;
            border-width: 2px;
            border-radius: 100%;
            opacity: 0;
            -webkit-animation: ball-scale-ripple-multiple 1.25s 0s infinite cubic-bezier(.21, .53, .56, .8);
            -moz-animation: ball-scale-ripple-multiple 1.25s 0s infinite cubic-bezier(.21, .53, .56, .8);
                -o-animation: ball-scale-ripple-multiple 1.25s 0s infinite cubic-bezier(.21, .53, .56, .8);
                    animation: ball-scale-ripple-multiple 1.25s 0s infinite cubic-bezier(.21, .53, .56, .8);
        }
        .la-ball-scale-ripple-multiple > div:nth-child(1) {
            -webkit-animation-delay: 0s;
            -moz-animation-delay: 0s;
                -o-animation-delay: 0s;
                    animation-delay: 0s;
        }
        .la-ball-scale-ripple-multiple > div:nth-child(2) {
            -webkit-animation-delay: .25s;
            -moz-animation-delay: .25s;
                -o-animation-delay: .25s;
                    animation-delay: .25s;
        }
        .la-ball-scale-ripple-multiple > div:nth-child(3) {
            -webkit-animation-delay: .5s;
            -moz-animation-delay: .5s;
                -o-animation-delay: .5s;
                    animation-delay: .5s;
        }
        .la-ball-scale-ripple-multiple.la-sm {
            width: 16px;
            height: 16px;
        }
        .la-ball-scale-ripple-multiple.la-sm > div {
            width: 16px;
            height: 16px;
            border-width: 1px;
        }
        .la-ball-scale-ripple-multiple.la-2x {
            width: 64px;
            height: 64px;
        }
        .la-ball-scale-ripple-multiple.la-2x > div {
            width: 64px;
            height: 64px;
            border-width: 4px;
        }
        .la-ball-scale-ripple-multiple.la-3x {
            width: 96px;
            height: 96px;
        }
        .la-ball-scale-ripple-multiple.la-3x > div {
            width: 96px;
            height: 96px;
            border-width: 6px;
        }
        /*
        * Animation
        */
        @-webkit-keyframes ball-scale-ripple-multiple {
            0% {
                opacity: 1;
                -webkit-transform: scale(.1);
                        transform: scale(.1);
            }
            70% {
                opacity: .5;
                -webkit-transform: scale(1);
                        transform: scale(1);
            }
            95% {
                opacity: 0;
            }
        }
        @-moz-keyframes ball-scale-ripple-multiple {
            0% {
                opacity: 1;
                -moz-transform: scale(.1);
                    transform: scale(.1);
            }
            70% {
                opacity: .5;
                -moz-transform: scale(1);
                    transform: scale(1);
            }
            95% {
                opacity: 0;
            }
        }
        @-o-keyframes ball-scale-ripple-multiple {
            0% {
                opacity: 1;
                -o-transform: scale(.1);
                transform: scale(.1);
            }
            70% {
                opacity: .5;
                -o-transform: scale(1);
                transform: scale(1);
            }
            95% {
                opacity: 0;
            }
        }
        @keyframes ball-scale-ripple-multiple {
            0% {
                opacity: 1;
                -webkit-transform: scale(.1);
                -moz-transform: scale(.1);
                    -o-transform: scale(.1);
                        transform: scale(.1);
            }
            70% {
                opacity: .5;
                -webkit-transform: scale(1);
                -moz-transform: scale(1);
                    -o-transform: scale(1);
                        transform: scale(1);
            }
            95% {
                opacity: 0;
            }
        }


   </style>