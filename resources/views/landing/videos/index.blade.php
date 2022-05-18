@extends('layouts.landing.index')
@section('content')
    <div class="container content-config">
        <div class="p-3 my-3 bg-primary d-flex justify-content-between text-white">
            <span id="videoResultHeading"></span>
            <span class="iconify cursor-pointer" data-bs-toggle="modal" data-bs-target="#videoModal"
                  data-icon="ri:equalizer-line" data-width="20" data-height="20"></span>
        </div>

        <div class="modal fade" id="videoModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 class="text-capitalize">Sort Video By</h6>

                    </div>
                    <div class="modal-body">
                        <form action="{{url('/api/file/video/search')}}" id="filterForm">
                            <div class="row">

                                <div class="col-lg-12 col-12 mb-3">
                                    <div class="form-group">
                                        <select name="filter" id="" class="form-select">
                                            <option value="date">Filter By Date</option>
                                            <option value="note">Filter By Note</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12 mb-3">
                                    <div class="form-group">
                                        <select name="video" id="" class="form-select">
                                            <option value="all">All Videos</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-12 mb-3">
                                    <div class="d-flex align-items-center justify-content-center mb-3">
                                        <input name="minage" type="text" class="form-control" placeholder="10">
                                        <label class="text-capitalize mx-3">to</label>
                                        <input name="maxage" type="text" class="form-control" placeholder="49">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" id="submit-button" class="btn btn-primary">Filter</button>
                                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="singleVideoModal">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h6 id="singleVideoTitle"></h6>
                    </div>
                    <div class="modal-body">
                        <div id="videoItem"></div>


                        <div class="card border my-3">
                            <div class="card-header" id="videoCard">
                                <div class="text-center">
                                    <h6>Comments</h6>
                                </div>
                            </div>

                            <div class="card-body">
                                <ul id="commentBody"></ul>
                            </div>

                            <div class="card-action p-2 border-top d-none" id="commentAction">
                                <div class="text-center">
                                    <div id="rater"></div>
                                    <p>Grade this video</p>
                                </div>
                                <form id="commentForm">
                                    <input type="hidden" id="videoId" name="video_id">
                                    <textarea name="comment" id="comment" placeholder="Write your comment" class="form-control comment" onchange="clearError(this)"></textarea>
                                    <span id="comment_error" class="text-danger comment_error"></span>
                                    <button type="submit" id="comment-submit-button" class="btn btn-primary  my-2">Comment</button>
                                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary my-2">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="p-3">
            <div class="row bg-white p-2" id="allVideoList"></div>
        </div>
    </div>


@endsection
@push('custom-js')
    <script>

        /**
         * Change the current page title
         * */
        window.location.pathname === '/videos'? document.title = 'Videos' : ''



        $(document).ready(function () {
            let   token = localStorage.getItem('accessToken')
            const api = {
                fetch_all: '/api/file/video',
                fetch_single: '/api/file/video/:id',
                comment: '/api/video/comment/:id',
            }

            if(token){
                $('#commentAction').removeClass('d-none')
                $('.video-blur').removeClass('img-blur')
                $('.userImg').removeClass('img-blur')
            }

            function fetch(url, fetch) {
                $.ajax({
                    url: window.origin + url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (res) {
                        fetch(res)
                    }, error: function (jqXhr, ajaxOptions, thrownError) {
                        console.log(jqXhr)
                    }
                });
            }


            //fetch all videos
            fetch(api.fetch_all, videoList)




            function videoList(res) {
                if(res.status === 'success' && res.data.length > 0){
                    $('#videoResultHeading').text('you can filter the video here.')
                    res.data.forEach(item => {
                        $('#allVideoList').append(`
                            <div class="col-lg-4 col-sm-12 col-12 mb-3 ">
                                <div class="card cursor-pointer " onclick="playVideo(${item.id})">
                                    <div class="card-body">
                                         <video width="320" height="240" class=" video-blur">
                                            <source src="${item.video}" type="video/mp4">
                                            Your browser does not support the video tag.
                                         </video>

                                        <div class='d-flex'>
                                            <img style='width: 80px; height: 80px;' class=" userImg" id="" src='${item.user.image ? item.user.image : window.origin + '/asset/image/default.png'}' alt=""/>

                                            <div class="ms-2">
                                                <div class="d-flex align-items-center">
                                                   <span class="iconify text-warning me-2" data-icon="bxs:star" data-width="20" data-height="20"></span>
                                                   <span id='rating-count' class=''></span>
                                                </div>
                                               <h6 class=''>${item.user.username}</h6>
                                               <span class=''>${item.user.address}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div>
                        `)

                        fetch('/api/rating/count/'+item.id, ratingCount)

                        function ratingCount(res){
                            $('#rating-count').text(res.data)
                            console.log('count', res.data)
                        }
                    })


                }else{
                    $('#videoResultHeading').text('No one posted any video yet.')
                    $('#allVideoList').hide()
                }

            }


            let video_id = null
            playVideo = function (id) {
                if(token){
                    // window.location.href = window.origin + '/videos?modal/id='+id;

                    $('#singleVideoModal').modal('show')
                    fetch(api.fetch_single.replace(':id', id), singleVideo)
                    fetch(api.comment.replace(':id', id), videoComment)
                    video_id = id
                }else{
                    $('#loginModal').modal('show')
                }


            }



            function singleVideo(res) {
                $('#singleVideoTitle').text(res.data.user.username)
                $('#videoId').val(res.data.id)
                $('#videoItem').html('')
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


            function videoComment(res){
                if(res.status === 'success' && res.data.length > 0){
                    $('#commentBody').html('')
                    res.data.forEach(item =>{
                        $('#commentBody').append(`
                         <li class="border-bottom d-flex py-1">
                            ${item.user.image ? (`
                                    <img style="width: 80px; height: 80px;" class="border" src="${item.user.image}" alt="">
                            `) : ''}
                            <div class="ms-3">
                                <h6>${item.user.username}</h6>
                                <span>${item.comment}</span>
                            </div>
                        </li>
                    `)
                    })
                }else{
                    $('#commentBody').text('')
                    $('#commentBody').append(`
                        <div class="alert alert-warning text-center">No one commented in this video.</div>
                    `)
                }

            }

            let myRating = raterJs( {
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
                videoRating(video_id, rate)
            })
        })
        videoRating = function (videoId, rating){
            let token = localStorage.getItem('accessToken')
            $.ajax({
                type: 'post',
                url: window.origin + '/api/rating/store',
                data: {
                    'video_id':videoId,
                    'rating': rating
                },
                beforeSend: function () {
                    $('#comment-submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                }, success: function (response) {
                    toastr.success(response.message)

                }, error: function (xhr, resp, text) {
                    console.log(xhr)
                },
                complete: function (xhr, status) {
                    $('#comment-submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });

        }



        $('#commentForm').submit(function (e) {
            e.preventDefault();
            let token = localStorage.getItem('accessToken')
            let form = $(this);
            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data)

            $.ajax({
                type: 'post',
                url: window.origin + '/api/video/comment',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': token
                },
                beforeSend: function () {
                    $('#comment-submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {
                    toastr.success(response.message)
                    $('#comment').val('')
                    location.reload()

                }, error: function (xhr, resp, text) {
                    if (xhr && xhr.responseJSON) {
                        let response = xhr.responseJSON;
                        if (response.status && response.status === "validate_error") {
                            $.each(response.message, function (index, message) {
                                $("." + message.field).addClass("is-invalid");
                                $("." + message.field + "_label").addClass( "text-danger");
                                $("." + message.field + "_error").html(message.error);
                            });
                        }
                    }
                },
                complete: function (xhr, status) {
                    $('#comment-submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })

        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
            $('#' + input.id + '_register_error').html('');
        }



        $('#filterForm').submit(function (e) {
            e.preventDefault();
            let form = $(this);

            let form_data = JSON.stringify(form.serializeJSON());
            let formData = JSON.parse(form_data);

            let url = form.attr("action");
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                beforeSend: function () {
                    $('#submit-button').prop('disabled', true);
                    $('#preloader').removeClass('d-none');
                },
                success: function (response) {

                    $('#videoModal').modal('hide')
                    $(".modal-backdrop").remove();

                    // $('#videoResultHeading').text('Result: from'+ formData.minage +' years old to'+ formData.maxage +' years old ')

                    $('#allVideoList').html('')
                    response.data.forEach(item => {
                        $(".modal-backdrop").add();
                        $('#allVideoList').append(`
                            <div class="col-lg-4 col-sm-12 col-12 mb-3 ">
                                <div class="card cursor-pointer " onclick="playVideo(${item.id})">
                                    <div class="card-body">
                                         <video width="320" height="240" class=" video-blur">
                                            <source src="${item.video}" type="video/mp4">
                                            Your browser does not support the video tag.
                                         </video>

                                        <div class='d-flex'>
                                            <img style='width: 80px; height: 80px;' class=" userImg" id="" src='${item.user.image ? item.user.image : window.origin + '/asset/image/default.png'}' alt=""/>

                                            <div class="ms-2">
                                                <div class="d-flex align-items-center">
                                                    <span class="iconify text-warning me-2" data-icon="bxs:star" data-width="20" data-height="20"></span>
                                                   <span id='rating-count' class='text-white'></span>
                                                </div>
                                               <h6 class=''>${item.user.username}</h6>
                                               <span class=''>${item.user.address}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div>
                        `)
                    })
                },
                error: function (xhr, resp, text) {
                    console.log(xhr);

                }, complete: function (xhr, status) {
                    $('#submit-button').prop('disabled', false);
                    $('#preloader').addClass('d-none');
                }
            });
        })



    </script>
@endpush
