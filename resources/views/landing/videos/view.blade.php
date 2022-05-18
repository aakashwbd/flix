<?php
    $currentControllerName = Request::segment(2);
?>

@extends('layouts.landing.index')
@section('content')
    <div class="container content-config" id="weekVideo">
        <div class="row">
            <div class="col-lg-6 col-12 col-sm-12">
                <div id="videoItem"></div>
            </div>
            <div class="col-lg-6 col-12 col-sm-12">
                <div class="card border">
                    <div class="card-header" id="videoCard">

                    </div>
                    <div class="card-body">
                        <ul id="commentBody">

                        </ul>
                    </div>
                    <div class="card-action p-2 border-top">
                        <form id="commentForm" class="text-center">
                            <div id="rater"></div>
                            <span class="d-block">Grade</span>
                            <div class="d-flex align-items-center">
                                <input type="hidden" id="videoId" name="video_id">
                                <input type="hidden" id="ratings" name="rating">
                                <input type="text" name="comment" placeholder="write your comment" class="form-control me-2">
                                <button type="submit" class="btn btn-primary">Ok</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
@push('custom-js')
    <script>
        const url = {
            videoURL: '/api/file/video/<?= $currentControllerName?>',
            videoCommentURL: '/api/video/comment/<?= $currentControllerName?>',
        }
        $(document).ready(function (){
            $.ajax({
                url: window.origin + url.videoURL,
                type: 'GET',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    console.log('video', res)
                    if(res.status === 'success'){
                        $('#videoId').val(res.data.id)
                        $('#videoCard').append(`
                             <h6>${res.data.user.username}</h6>

                        `)
                        $('#videoItem').append(`
                            <video
                                id="my-video"
                                class="video-js"
                                controls
                                 style="width: 100%; height: 50%"
                                preload="auto"
                                data-setup="{}"
                              >
                                <source src="${res.data.video}" type="video/mp4" />
                                <p class="vjs-no-js">
                                  To view this video please enable JavaScript, and consider upgrading to a
                                  web browser that
                                  <a href="https://videojs.com/html5-video-support/" target="_blank"
                                    >supports HTML5 video</a
                                  >
                                </p>
                              </video>
                        `)

                    }
                    // getVideoContent(res)

                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });


            $.ajax({
                url: window.origin + url.videoCommentURL,
                type: 'GET',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    res.data.forEach(item =>{
                        $('#commentBody').append(`
                             <li class="border-bottom">
                                <h6>${item.user.username}</h6>
                                <span>${item.comment}</span>
                            </li>
                    `)
                    })

                }, error: function (jqXhr, ajaxOptions, thrownError) {
                    console.log(jqXhr)
                }
            });
        })


        var myRating = raterJs( {
            element:document.querySelector("#rater"),
            rateCallback:function rateCallback(rating, done) {
                this.setRating(rating);
                done();
            },
            showToolTip: true,
            max: 5,
        });

        $(document).on('click', '#rater', function (){
           let rate = $(this).attr('data-rating')
            $('#ratings').val(rate)
        })



        $('#commentForm').submit(function (e) {
            e.preventDefault();
            let token = localStorage.getItem('accessToken')
            let form = $(this);
            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data)

            $.ajax({
                type: 'post',
                url: window.origin + '/api/rating/store',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                }, success: function (response) {
                    toastr.success(response.message)

                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                }
            });

            $.ajax({
                type: 'post',
                url: window.origin + '/api/video/comment',
                data: formData,
                headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                }, success: function (response) {
                    toastr.success(response.message)

                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                }
            });
        })



{{--        $(document).on('click', "#rater", function (){--}}
{{--            let token = localStorage.getItem('accessToken')--}}
{{--            let rate = $(this).attr('data-rating')--}}
{{--            let video = 2--}}

{{--            let formData = new FormData();--}}
{{--            formData.append('rating', rate)--}}
{{--            formData.append('video_id', video)--}}

{{--            $.ajax({--}}
{{--                url: window.origin + '/api/rating/store',--}}
{{--                type: 'POST',--}}
{{--                data: formData,--}}
{{--                dataType: "json",--}}
{{--                processData: false,--}}
{{--                contentType: false,--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),--}}
{{--                    'Authorization': token--}}
{{--                },--}}
{{--                success: function (res) {--}}

{{--                    toastr.success(res.message)--}}

{{--                }, error: function (jqXhr, ajaxOptions, thrownError) {--}}
{{--                    console.log(jqXhr)--}}
{{--                }--}}
{{--            });--}}
{{--        })--}}

{{--        $(document).ready(function (){--}}
{{--            let formData = new FormData();--}}
{{--            let video = 2--}}
{{--            formData.append('video_id', video)--}}
{{--            $.ajax({--}}
{{--                url: window.origin + '/api/rating/count',--}}
{{--                type: 'POST',--}}
{{--                data: formData,--}}
{{--                dataType: "json",--}}
{{--                processData: false,--}}
{{--                contentType: false,--}}
{{--                headers: {--}}
{{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),--}}
{{--                },--}}
{{--                success: function (res) {--}}
{{--                    $('#total-rating').append(`--}}
{{--                        <span class="text-white-50 ms-3">total ${res.data}</span>--}}
{{--                    `)--}}

{{--                }, error: function (jqXhr, ajaxOptions, thrownError) {--}}
{{--                    console.log(jqXhr)--}}
{{--                }--}}
{{--            });--}}
{{--        })--}}



{{--        $.ajax({--}}
{{--            url: window.origin + '/api/video/get-all',--}}
{{--            type: 'GET',--}}
{{--            dataType: "json",--}}
{{--            processData: false,--}}
{{--            contentType: false,--}}
{{--            headers: {--}}
{{--                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),--}}
{{--            },--}}
{{--            success: function (res) {--}}

{{--                getVideoContent(res)--}}

{{--            }, error: function (jqXhr, ajaxOptions, thrownError) {--}}
{{--                console.log(jqXhr)--}}
{{--            }--}}
{{--        });--}}

{{--        function getVideoContent(res) {--}}
{{--            res.data.forEach(item=>{--}}
{{--                $('#videoContent').append(`--}}
{{--                <div class="col-lg-4 col-sm-12 col-12 mb-3">--}}
{{--                <a href="{{url('video/${item.id}')}}" target="_blank">--}}
{{--                <video width="100%" height="300" class="border-warning">--}}
{{--                    <source src="${item.video}" type="video/mp4">--}}
{{--                </video>--}}
{{--</a>--}}

{{--                <div>--}}
{{--                    <h6 class="text-white">video title</h6>--}}



{{--                    <div class="d-flex align-items-center">--}}
{{--                        <span class="iconify text-warning me-2 star" data-video-id='${item.id}' data-rating-value='1' data-icon="clarity:star-solid"></span>--}}
{{--                        <span class="iconify text-warning me-2 star" data-video-id='${item.id}' data-rating-value='2' data-icon="clarity:star-solid"></span>--}}
{{--                        <span class="iconify text-warning me-2 star" data-video-id='${item.id}' data-rating-value='3' data-icon="clarity:star-solid"></span>--}}
{{--                        <span class="iconify text-warning me-2 star" data-video-id='${item.id}' data-rating-value='4' data-icon="clarity:star-solid"></span>--}}
{{--                        <span class="iconify text-warning me-2 star" data-video-id='${item.id}' data-rating-value='5' data-icon="clarity:star-solid"></span>--}}
{{--                        <span class="text-white mx-3">50 grades - 211 views</span>--}}
{{--                    </div>--}}
{{--                    <span class="text-white-50 fst-italic">published 2 years ago</span>--}}
{{--                </div>--}}

{{--                <div class="d-flex align-items-center my-3">--}}
{{--                    <img class="avatar-sm"--}}
{{--                         src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80"--}}
{{--                         alt="">--}}

{{--                    <div class="ms-4">--}}
{{--                        <h6 class="text-white-50 text-capitalize">--}}
{{--                            <span class="iconify text-primary" data-icon="carbon:location-filled" data-width="25" data-height="25"></span>--}}
{{--                            paris--}}
{{--                        </h6>--}}

{{--                        <span class="text-capitalize text-white-50 fs-6">name | 36y.o</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--                `)--}}
{{--            })--}}
{{--        }--}}

{{--        $(document).on('click','.vjs-big-play-button', function (){--}}
{{--            // window.location.replace()--}}
{{--           alert(window.origin+'/videos/1')--}}

{{--        })--}}



    </script>
@endpush
