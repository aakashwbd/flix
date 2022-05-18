@extends('layouts.landing.index')
@section('content')

    <div id="package" class="package content-config " style="min-height: 60vh">
        <div class="container bg-white my-5 py-3">

            <div class="row" id="packageList">
                <div class="col-lg-3 col-sm-12 col-12 mb-3">
                    <div class="package-item" id="free">
                        <h6 class="package-title" id="package-title-1"></h6>

                        <ul class="package-list" id="package-list-item-1">
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>

                                <span>view members directory</span>

                            </li>
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>
                                <span>
                                    view members profile
                                </span>

                            </li>
                            <li class="package-list-item package-list-inactive">
                                <span class="iconify icon" data-icon="emojione-monotone:cross-mark" data-width="20"
                                      data-height="20"></span>
                                <span>send 1 private message</span>


                            </li>
                            <li class="package-list-item package-list-inactive">
                                <span class="iconify icon" data-icon="emojione-monotone:cross-mark" data-width="20"
                                      data-height="20"></span>
                                <span>add 1 media to your profile</span>

                            </li>
                        </ul>

                        <h6 class="package-title" id="package-price-1"></h6>

                    </div>
                </div>

                <div class="col-lg-3 col-sm-12 col-12 mb-3">
                    <div class="package-item bronze" id="bronze">
                        <h6 class="package-title" id="package-title-2"></h6>

                        <ul class="package-list" id="package-list-item-2">
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>

                                <span>view members directory</span>

                            </li>
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>
                                <span>
                                    view members profile
                                </span>

                            </li>
                            <li class="package-list-item package-list-inactive">
                                <span class="iconify icon" data-icon="emojione-monotone:cross-mark" data-width="20"
                                      data-height="20"></span>
                                <span>send 3 private message</span>


                            </li>
                            <li class="package-list-item package-list-inactive">
                                <span class="iconify icon" data-icon="emojione-monotone:cross-mark" data-width="20"
                                      data-height="20"></span>
                                <span>add 3 media to your profile</span>

                            </li>
                        </ul>

                        <h6 class="package-price" id="package-price-2"></h6>

                        <span class="d-block">per month</span>
                        <span class="d-block text-capitalize" id="package-price-unlimited-2"></span>
                        <span class="d-block text-capitalize" id="package-price-limited-2"></span>
{{--                        <span class="d-block text-capitalize">7 month billed a payment of 42</span>--}}
                        <button class="btn btn-outline-light mt-3" id="payBtn2">Buy Now</button>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-12 col-12 mb-3">
                    <div class="package-item silver">
                        <h6 class="package-title" id="package-title-3"></h6>
                        <span>popular plan</span>

                        <ul class="package-list" id="package-list-item-3">
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>

                                <span>view members directory</span>

                            </li>
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>
                                <span>
                                    view members profile
                                </span>

                            </li>
                            <li class="package-list-item package-list-inactive">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>
                                <span>send 5 private message</span>


                            </li>
                            <li class="package-list-item package-list-inactive">
                                <span class="iconify icon" data-icon="emojione-monotone:cross-mark" data-width="20"
                                      data-height="20"></span>
                                <span>add 5 media to your profile</span>

                            </li>
                        </ul>

                        <h6 class="package-price" id="package-price-3"></h6>

                        <span class="d-block">per month</span>
                        <span class="d-block text-capitalize" id="package-price-unlimited-3"></span>
                        <span class="d-block text-capitalize" id="package-price-limited-3"></span>
{{--                        <span class="d-block text-capitalize">7 month billed a payment of 42</span>--}}
                        <button class="btn btn-outline-light mt-3" id="payBtn3">Buy Now</button>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-12 col-12 mb-3">
                    <div class="package-item plus">
                        <h6 class="package-title" id="package-title-4"></h6>
                        <ul class="package-list" id="package-list-item-4">
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>

                                <span>view members directory</span>

                            </li>
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>
                                <span>
                                    view members profile
                                </span>

                            </li>
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>
                                <span>send 3 private message</span>


                            </li>
                            <li class="package-list-item package-list-active">
                                <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                      data-width="20" data-height="20"></span>
                                <span>add 3 media to your profile</span>

                            </li>
                        </ul>

                        <h6 class="package-price" id="package-price-4"></h6>

                        <span class="d-block">per month</span>
                        <span class="d-block text-capitalize" id="package-price-unlimited-4"></span>
                        <span class="d-block text-capitalize" id="package-price-limited-4"></span>
{{--                        <span class="d-block text-capitalize">7 month billed a payment of 42</span>--}}

                        <button class="btn btn-outline-light mt-3" id="payBtn4">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="payModal2" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="text-capitalize">Payment: </h6>
                </div>
                <div class="modal-body">

                    <span id="modal-package-name2"></span>
                    <h6 id="modal-package-price2"></h6>

                    <div id="paypal-button-container3"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="payModal3" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="text-capitalize">Payment: </h6>
                </div>
                <div class="modal-body">

                    <span id="modal-package-name3"></span>
                    <h6 id="modal-package-price3"></h6>

                    <div id="paypal-button-container2"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="payModal4" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="text-capitalize">Payment: </h6>
                </div>
                <div class="modal-body">
                    <span id="modal-package-name4"></span>
                    <h6 id="modal-package-price4"></h6>

                    <div id="paypal-button-container1"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('custom-js')
    <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_CLIENT_ID')}}&currency={{env('PAYPAL_CURRENCY')}}"></script>
    <script>
        /**
         * Change the current page title
         * */
        window.location.pathname === '/package'? document.title = 'Packages' : ''



        let bronzePrice = null
        let silverPrice = null
        let plusPrice = null

        let bronzePackage = null
        let silverPackage = null
        let plusPackage = null


        $(document).ready(function () {
            $.ajax({
                url: window.origin + '/api/admin/package/all-list',
                type: 'get',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    if (res.status === 'success') {
                        res.data.forEach(item=>{
                            console.log(item)

                            if(item.id === 1){
                                $('#package-title-1').text(item.name ? item.name : '')
                                $('#package-price-1').text(item.price ? item.price : '')

                                if(item.list){
                                    item.list.forEach(list=>{
                                        $('#package-list-item-1').append(`
                                                <li class="package-list-item package-list-active">
                                                    <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                                          data-width="20" data-height="20"></span>
                                                    <span>${list}</span>
                                                </li>
                                            `)
                                    })
                                }
                            }

                            if(item.id === 2){
                                $('#package-title-2').text(item.name ? item.name : '')
                                $('#package-price-2').text(item.price ? '$ '+ item.price : '')
                                $('#modal-package-name2').text('Package Name: ' + item.name)
                                $('#modal-package-price2').text(item.price ? 'Price: $' + item.price : '')
                                bronzePrice = item.price
                                bronzePackage = item

                                if(item.list){
                                     item.list.forEach(list=>{
                                         $('#package-list-item-2').append(`
                                                <li class="package-list-item package-list-active">
                                                    <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                                          data-width="20" data-height="20"></span>
                                                    <span>${list}</span>
                                                </li>
                                            `)
                                     })
                                }

                                $('#package-price-unlimited-2').text(item.unlimited ? 'unlimited '+ item.unlimited+  ' month' : '')
                                $('#package-price-limited-2').text(item.limited ? '( ' +item.limited + ' month free) ' : '')

                            }

                            if(item.id === 3){
                                $('#package-title-3').text(item.name ? item.name : '')
                                $('#package-price-3').text(item.price ? '$ '+ item.price : '')
                                $('#modal-package-name3').text('Package Name: ' + item.name)
                                $('#modal-package-price3').text(item.price ? 'Price: $' + item.price : '')
                                silverPrice = item.price
                                silverPackage = item


                                if(item.list){
                                    item.list.forEach(list=>{
                                        $('#package-list-item-3').append(`
                                                <li class="package-list-item package-list-active">
                                                    <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                                          data-width="20" data-height="20"></span>
                                                    <span>${list}</span>
                                                </li>
                                            `)
                                    })
                                }

                                $('#package-price-unlimited-3').text(item.unlimited ? 'unlimited '+ item.unlimited+  ' month' : '')
                                $('#package-price-limited-3').text(item.limited ? '( ' +item.limited + ' month free) ' : '')

                            }

                            if(item.id === 4){
                                $('#package-title-4').text(item.name ? item.name : '')
                                $('#package-price-4').text(item.price ? '$ '+ item.price : '')
                                $('#modal-package-name4').text('Package Name: ' + item.name)
                                $('#modal-package-price4').text(item.price ? 'Price: $' + item.price : '')
                                plusPrice = item.price
                                plusPackage = item

                                $('#package-price-unlimited-4').text(item.unlimited ? 'unlimited '+ item.unlimited+  ' month' : '')
                                $('#package-price-limited-4').text(item.limited ? '( ' +item.limited + ' month free) ' : '')

                                if(item.list){
                                    item.list.forEach(list=>{
                                        $('#package-list-item-4').append(`
                                                <li class="package-list-item package-list-active">
                                                    <span class="iconify icon" data-icon="emojione-monotone:heavy-check-mark"
                                                          data-width="20" data-height="20"></span>
                                                    <span>${list}</span>
                                                </li>
                                            `)
                                    })
                                }
                            }
                        })
                    }

                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });

        })



        let price = null
        let packageList = null
        let user = JSON.parse(localStorage.getItem('user'))
        $(document).on('click', '#payBtn2', function () {


            if(user){
                $('#payModal2').modal('show')
                price = bronzePrice
                packageList = JSON.stringify(bronzePackage)
            }else{
                $('#loginModal').modal('show')
            }




        })

        $(document).on('click', '#payBtn3', function () {


            if(user){
                $('#payModal3').modal('show')
                price = silverPrice
                packageList = JSON.stringify(silverPackage)
            }else{
                $('#loginModal').modal('show')
            }


        })

        $(document).on('click', '#payBtn4', function () {

            if(user){
                $('#payModal4').modal('show')
                price = plusPrice
                packageList = JSON.stringify(plusPackage)
            }else{
                $('#loginModal').modal('show')
            }


        })





        const paypalButtonsComponent = paypal.Buttons({
            style: {
                color: "gold",
                shape: "rect",
                layout: "vertical"
            },

            createOrder: (data, actions) => {
                const createOrderPayload = {
                    intent: "CAPTURE",
                    purchase_units: [
                        {
                            reference_id: "REFID-000-1001",
                            amount: {
                                value: price
                            }

                        }
                    ],
                };

                return actions.order.create(createOrderPayload);
            },

            onApprove: (data, actions) => {
                const captureOrderHandler = (details) => {
                    let token = localStorage.getItem('accessToken')
                    let list = JSON.parse(packageList)
                    $.ajax({
                        url: window.origin + '/api/checkout',
                        type: 'POST',
                        data: list,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Authorization': token
                        },
                        success: function (res) {
                            console.log(res)
                        }, error: function (jqXhr, ajaxOptions, thrownError) {
                            console.log(jqXhr)
                        }
                    });
                };
                return actions.order.capture().then(captureOrderHandler);
            },
            onError: (err) => {
                console.error('An error prevented the buyer from checking out with PayPal');
            }
        });

        paypalButtonsComponent
            .render("#paypal-button-container1")
            .catch((err) => {
                console.error('PayPal Buttons failed to render');
            });

        paypalButtonsComponent
            .render("#paypal-button-container2")
            .catch((err) => {
                console.error('PayPal Buttons failed to render');
            });

        paypalButtonsComponent
            .render("#paypal-button-container3")
            .catch((err) => {
                console.error('PayPal Buttons failed to render');
            });
    </script>
@endpush
