{{--@extends('layouts.landing.index')--}}
{{--@section('content')--}}

{{--    <div id="package" class="package content-config " style="min-height: 60vh">--}}
{{--        <div class="container bg-white my-5 py-3">--}}
{{--            <div id="paypal-button-container"></div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--@endsection--}}
{{--@push('custom-js')--}}
{{--    <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&currency={{env('PAYPAL_CURRENCY')}}"></script>--}}
{{--    <script>--}}
{{--        let path = window.location.pathname--}}
{{--        let pathSplit = path.split('/')--}}
{{--        let price = pathSplit[2]--}}

{{--        console.log(price)--}}


{{--        const paypalButtonsComponent = paypal.Buttons({--}}
{{--            // optional styling for buttons--}}
{{--            // https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/--}}
{{--            style: {--}}
{{--                color: "gold",--}}
{{--                shape: "rect",--}}
{{--                layout: "vertical"--}}
{{--            },--}}

{{--            // set up the transaction--}}
{{--            createOrder: (data, actions) => {--}}
{{--                // pass in any options from the v2 orders create call:--}}
{{--                // https://developer.paypal.com/api/orders/v2/#orders-create-request-body--}}
{{--                const createOrderPayload = {--}}
{{--                    purchase_units: [--}}
{{--                        {--}}
{{--                            amount: {--}}
{{--                                value: price--}}
{{--                            }--}}
{{--                        }--}}
{{--                    ]--}}
{{--                };--}}

{{--                return actions.order.create(createOrderPayload);--}}
{{--            },--}}

{{--            // finalize the transaction--}}
{{--            onApprove: (data, actions) => {--}}
{{--                const captureOrderHandler = (details) => {--}}
{{--                    const payerName = details.payer.name.given_name;--}}
{{--                    console.log('Transaction completed');--}}
{{--                };--}}

{{--                console.log(data)--}}


{{--                return actions.order.capture().then(captureOrderHandler);--}}
{{--            },--}}

{{--            // handle unrecoverable errors--}}
{{--            onError: (err) => {--}}
{{--                console.error('An error prevented the buyer from checking out with PayPal');--}}
{{--            }--}}
{{--        });--}}

{{--        paypalButtonsComponent--}}
{{--            .render("#paypal-button-container")--}}
{{--            .catch((err) => {--}}
{{--                console.error('PayPal Buttons failed to render');--}}
{{--            });--}}
{{--    </script>--}}
{{--@endpush--}}
