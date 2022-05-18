@extends('layouts.admin.index')
@section('content')
    <main class="main">
        <section class="dashboard-home">
            <div class="heading">
                <span class="fw-bold">👋 Hello!</span>
                <h6 class="my-3 fw-bold fs-3">Welcome <span class="text-primary" id="adminName">Admin Name</span></h6>
                <span class="page-title">User Overview</span>
            </div>

            <div class="row my-3 justify-content-between">
                <div class="col-lg-7 col-sm-12 col-12">
                    <div class="row" id="total-count-container">

                    </div>
                </div>

                <div class="col-lg-4 col-sm-12 col-12">
                    <div class="dayWeekCounter">
                        <ul class="nav nav-tabs" id="dayWeekCounter-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="last-day-btn" data-bs-toggle="tab"
                                        data-bs-target="#last-day-content" type="button" role="tab"
                                        aria-controls="last-day-content" aria-selected="true">Last Day
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="week-tab-btn" data-bs-toggle="tab"
                                        data-bs-target="#last-week-content" type="button" role="tab"
                                        aria-controls="last-week-content" aria-selected="false">Last Week
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="dayWeekCounter-tab-content">
                            <div class="tab-pane fade show active" id="last-day-content" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <div class="count-box">
                                            <h2 class="count-number">0</h2>
                                            <span class="count-title">Total View</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="count-box count-subscribe">
                                            <h2 class="count-number ">0</h2>
                                            <span class="count-title">Subscribed</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="count-box count-unsubscribe">
                                            <h2 class="count-number ">0</h2>
                                            <span class="count-title">Unsubscribed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="last-week-content" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-4 col-4">
                                        <div class="count-box">
                                            <h2 class="count-number">0</h2>
                                            <span class="count-title">Total View</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="count-box count-subscribe">
                                            <h2 class="count-number ">0</h2>
                                            <span class="count-title">Subscribed</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-4">
                                        <div class="count-box count-unsubscribe">
                                            <h2 class="count-number ">0</h2>
                                            <span class="count-title">Unsubscribed</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('custom-js')
    <script>
        /**
         * Change the current page title
         * */
        window.location.pathname === '/admin'? document.title = 'Dashboard' : ''



        $(document).ready(function (){
            authRestrictionHandler()

            $.ajax({
                type: "GET",
                url: window.origin + '/api/admin/dashboard/total-count',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if(response.status === 'success' ){

                        response.data.forEach(item =>{
                            Object.entries(item).forEach(value => {
                                $('#total-count-container').append(`
                                    <div class="col-lg-4 col-sm-12 mb-3">
                                        <div class="card">
                                            <div class="d-flex justify-content-between ">
                                                <div>
                                                    <h2 class="">${value[1]}</h2>
                                                    <span class="">Total ${value[0]}</span>
                                                </div>
                                                <div class="count-icon-box d-flex align-items-center justify-content-center">
                                                    <span class="iconify position-center" data-icon="ic:outline-category"
                                                          style="color: #da0f0f;" data-width="30" data-height="30"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            `)
                            })

                        })
                    }
                }, error: function (xhr, resp, text) {
                    console.log(xhr && xhr.responseJSON)
                }
            });
        })
    </script>
@endpush
