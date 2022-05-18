@extends('layouts.landing.index')
@section('content')


    <div class="container content-config" style="min-height: 60vh">
        <div class="bg-primary p-4 d-flex align-items-center justify-content-between">
            <span class="text-white">no exhib in process</span>
            <span data-bs-target="#infoModal" data-bs-toggle="modal" class="iconify text-white cursor-pointer" data-icon="entypo:info-with-circle" data-width="20" data-height="20"></span>
        </div>

        <div class="bg-white p-3">
            <div class="row">
                <div class="col-lg-3">
                    <div class="exhibitBox">
                        <span class="iconify text-white me-3" data-icon="bxs:video-plus" data-width="50" data-height="50"></span>
                        <span class="text-center text-white fs-4">
                            You want to exhibit yourself? <br>
                            <a href="{{url('/streaming')}}" class="text-white text-decoration-underline">click here</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="infoModal" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h6 class="text-capitalize">Exhibits - infos</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Welcome to our video exhibition module</p>

                    <span class="text-black-50">This one is currently under development, we will correct the various bugs and improve the functionalities as we go.</span>

                    <ul class="my-2" >
                        <li style="list-style-type: disc">To check that your webcam is work properly, <a href="" class="text-decoration-underline">click here</a></li>
                        <li style="list-style-type: disc">On android, to modify your webcam access settings, <a href="" class="text-decoration-underline">click here</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
{{--    <Broadcast />--}}
@endsection

@push('custom-js')
    <script>
        // function modalToggleHandler() {
        //     $('#infoModal').modal('show')
        // }

        /**
         * Change the current page title
         * */
        window.location.pathname === '/live'? document.title = 'Live' : ''


    </script>
@endpush
