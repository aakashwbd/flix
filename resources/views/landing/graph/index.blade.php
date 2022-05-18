<?php
$currentControllerName = Request::segment(1);
$currentFullRouteName = Route::getFacadeRoot()
    ->current()
    ->uri();
?>


@extends('layouts.landing.index')
@section('content')
    <section class="graph_section">
        <div class="container">
            <ul class="nav nav-tabs bg-primary border-0 justify-content-center" id="graphTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button onclick="tabChangerHandler('visitor')" class="nav-link {{ ((request()->get('tab')) == "visitor") ? "active" : ''}}" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">Visit
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button  onclick="tabChangerHandler('flash')" class="nav-link {{ ((request()->get('tab')) == "flash") ? "active" : ''}}" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profiles"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Flash
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button onclick="tabChangerHandler('testimony')" class="nav-link {{ ((request()->get('tab')) == "testimony") ? "active" : ''}}" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">Testimony
                    </button>
                </li>
            </ul>
            <div class="tab-content bg-white" id="graphTabContent">
                <div class="tab-pane fade show {{ ((request()->get('tab')) == "visitor") ? "active" : ''}}" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <ul id="visitorList" class="p-2"></ul>

                </div>
                <div class="tab-pane fade show {{ ((request()->get('tab')) == "flash") ? "active" : ''}}" id="profiles" role="tabpanel" aria-labelledby="profile-tab">
                    <ul id="flashLists" class="p-2"></ul>
                </div>
                <div class="tab-pane fade show {{ ((request()->get('tab')) == "testimony") ? "active" : ''}}" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <ul id="testimonyList" class="p-2"></ul>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('custom-js')
    <script>
        let currentPath = window.location.pathname
        currentPath === '/graph' ? document.title = 'Graph' : ''

        let token = localStorage.getItem('accessToken')
        let user = JSON.parse(localStorage.getItem('user'))
        const api = {
            fetch_visitor: '/api/profile/visitors',
            fetch_testimony: '/api/testimony/' + user.id,
            fetch_flash: '/api/user/get-flash'
        }

        tabChangerHandler = function (tab){
            if(tab === 'visitor') {
                location.href = window.origin + '/graph?tab=visitor'
            }

            if(tab === 'flash') {
                location.href = window.origin + '/graph?tab=flash'
            }

            if(tab === 'testimony') {
                location.href = window.origin + '/graph?tab=testimony'
            }

        }

        dataFetch = function (url, fetch) {
            $.ajax({
                url: window.origin + url,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                success: function (res) {
                    fetch(res)
                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        }

        fetchVisitor = function (res) {
            if (res.status === 'success' && res.data.length > 0) {
                res.data.forEach(item => {
                    $('#visitorList').append(`
                                <li class="border-bottom d-flex p-2">
                                    <img style="width: 80px; height: 80px"  src="${item.user.image ? item.user.image : window.origin + '/asset/image/default.jpg'}" alt="">
                                    <div class="ms-3">
                                        <h6>${item.user.username ? item.user.username : ""}</h6>
                                        <h6>${item.user.address ? item.user.address : ""}</h6>
                                    </div>
                                </li>
                            `)
                })
            } else {
                $('#visitorList').append(`
                            <div class="alert alert-warning">
                                No one visited in your profile.
                            </div>
                        `)
            }
        }

        fetchTestimony = function (res) {

            if (res.status === 'success' && res.data.length > 0) {
                res.data.forEach(item => {
                    $('#testimonyList').append(`

                        <li class="border-bottom d-flex p-2">
                                    <img style="width: 80px; height: 80px"  src="${item.user.image ? item.user.image : window.origin + '/asset/image/default.jpg'}" alt="">
                                    <div class="ms-3">
                                        <h6>${item.user.username ? item.user.username : ""}</h6>
                                        <h6>${item.user.address ? item.user.address : ""}</h6>
                                    </div>
                                </li>
                        `)
                })
            } else {
                $('#testimonyList').append(`
                            <div class="alert alert-warning">
                                No one posted testimony in your profile.
                            </div>
                        `)
            }
        }

        fetchFlash = function (res) {


            if (res.status === 'success' && res.data.length > 0) {
                res.data.forEach(item => {
                    $('#flashLists').append(`

                            <li class="border-bottom d-flex p-2">
                                <img style="width: 80px; height: 80px"  src="${item.sender.image ? item.sender.image : window.origin + '/asset/image/default.jpg'}" alt="">
                                <div class="ms-3">
                                    <h6>${item.sender.username ? item.sender.username : ""}</h6>
                                    <h6>${item.sender.address ? item.sender.address : ""}</h6>
                                </div>
                            </li>
                        `)
                })
            } else {
                $('#flashLists').append(`
                            <div class="alert alert-warning">
                                No one flashed in your profile.
                            </div>
                        `)
            }
        }

        $(document).ready(function () {
            dataFetch(api.fetch_visitor, fetchVisitor)
            dataFetch(api.fetch_testimony, fetchTestimony)
            dataFetch(api.fetch_flash, fetchFlash)
        })
    </script>


@endpush
