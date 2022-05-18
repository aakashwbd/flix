<?php

$host = $_SERVER['HTTP_HOST'];
$currentURI = $_SERVER['REQUEST_URI'];
$currentPage = $host . $currentURI;
$explode = explode('/', $currentPage);
$comment_id = null;

if (sizeof($explode) === 3) {
    $comment_id = $explode[2];
}

?>

@extends('layouts.landing.index')
@section('content')

    <div id="blog" class="blog container">
        <nav class="bg-primary">
            <div class="nav nav-tabs justify-content-center border-0" id="nav-tab" role="tablist">

                <button
                    onclick='tabChangerHandler("recent")'
                    class="nav-link bg-transparent border-0 {{ ((request()->get('tab')) === "blogs") ? "active" : ''}}  text-white"
                    id="nav-recent-tab" data-bs-toggle="tab" data-bs-target="#nav-recent"
                    type="button" role="tab">Recent

                </button>


                <button
                    disabled
                    class="nav-link bg-transparent border-0 {{ ((request()->get('tab')) === "comments/$comment_id") ? "active" : ''}}  text-white"
                    id="nav-comment-tab" data-bs-toggle="tab" data-bs-target="#nav-comment"
                    type="button" role="tab">Comment
                </button>
            </div>
        </nav>

        <div class="tab-content bg-white p-4" id="nav-tabContent">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="tab-pane fade show  {{ ((request()->get('tab')) === "blogs") ? "active" : ''}}"
                         id="nav-recent" role="tabpanel">

                        <div id="top-blog"></div>
                        <div id="emptyBlogList" class="d-none alert alert-warning">Please create a new blog to view the list.</div>
                        <div class="row" id="blogList"></div>
                    </div>


                    <div class="tab-pane fade show {{((request()->get('tab')) === "comments/$comment_id") ? "active" : ''}}"id="nav-comment" role="tabpanel">
                        <div id="singleBlog">

                        </div>
                        <div id="blogCommentList">
{{--                            <form action="{{url('/api/blog/comment')}}" class="d-flex align-items-center" id="blogCommentForm">--}}
{{--                                <input type="hidden" id="blog_id" name="blog_id" value="">--}}
{{--                                <input type="text" name="comment_text" class="form-control me-3" placeholder="write your comment">--}}
{{--                                <button class="btn btn-primary">Send</button>--}}
{{--                            </form>--}}
                        </div>


                    </div>
                </div>

                <div class="col-lg-4 col-sm-12 col-12">
                    <div class="title">
                        <span id="popularBlogListTitle" class="d-none bg-primary text-white py-1 px-4">Popular</span>
                    </div>

{{--                    <div class="d-flex align-items-center my-3">--}}
{{--                        <img class="avatar-sm-1"--}}
{{--                             src="https://images.unsplash.com/photo-1545239351-ef35f43d514b?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80"--}}
{{--                             alt="">--}}

{{--                        <div class="ms-3">--}}
{{--                            <a href="{{url('/blogs?tab=comments')}}/{{'blogid'}}" class="text-black d-block">Lorem ipsum--}}
{{--                                dolor sit amet, consectetur--}}
{{--                                adipisicing elit. Excepturi, nam?</a>--}}

{{--                            <span class="text-black-50 text-capitalize">14 april, 2022</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}


                </div>
            </div>

        </div>
    </div>

@endsection

@push('custom-js')
    <script>

        tabChangerHandler = function (tab){
            if(tab === 'recent'){
                location.href = window.origin + '/blogs?tab=blogs'
            }


        }


        let constant = {
            location: window.location.search,
            allBlogs: '?tab=blogs',
            singleBlog: '?tab=comments/<?= $comment_id?>',
            allBlogURL : '/api/admin/blog/get-all',
            singleBlogURL : '/api/admin/blog/<?= $comment_id?>'
        }

        function allBlog(res){
            if(res.data.length > 0){
                // $('#popularBlogListTitle').removeClass('d-none')
                res.data.forEach(item => {
                    $('#blogList').append(`
                            <div class="col-lg-6 col-sm-12 col-12 my-5">
                                <a href="{{url('/blogs?tab=comments')}}/${item.id}">
                                    <div class='card border'>
                                        <img class="card-img-top" src="${item.image}" alt="">
                                        <div class='card-body'>
                                             <h6 class="my-3">${item.title}</h6>
                                            <span class="text-black-50 fst-italic text-capitalize"></span>
                                            <article class="text-black-50 blog-short-description my-2">
                                                ${item.description}
                                            </article>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    `)
                })
            }else{
                $('#emptyBlogList').removeClass('d-none')
            }

        }

        function clearError(input) {
            $('#' + input.id).removeClass('is-invalid');
            $('#' + input.id + '_label').removeClass('text-danger');
            $('#' + input.id + '_icon').removeClass('text-danger');
            $('#' + input.id + '_icon_border').removeClass('field-error');
            $('#' + input.id + '_error').html('');
        }

        function singleBlog(res){
            let token = localStorage.getItem('accessToken')
            $('#singleBlog').append(`

                    <div class='card border'>

                        <div class='card-body'>
                            ${res.data.image ?
                (`
                             <img style='width: 100%; height: 300px' class='mb-3' src="${res.data.image}" alt="">

                            `) :

                ''
            }

                    <h6>${res.data.title}</h6>
                    <article>${res.data.description}</article>
                        </div>


                    </div>


                    ${token ? (`
                         <form action="{{url('/api/blog/comment')}}" class=" mt-5" id="blogCommentForm">
                                 <div class='w-100'>
                                    <input type="hidden" id="blog_id" name="blog_id" value="${res.data.id}">
                                    <input type="text" id='comment_text' name="comment_text" class="form-control me-3 comment_text" placeholder="write your comment" onchange="clearError(this)">
                                    <span id='comment_text_error' class='text-danger comment_text_error'></span>
                                </div>

                                <button id='submit-button' class="btn btn-primary  mt-3">Comment</button>
                         </form>

                    `) : ''}
            `)

            $('#blogCommentForm').submit(function (e) {
                e.preventDefault();
                let token = localStorage.getItem('accessToken')
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
                        "Authorization": token,
                    },
                    beforeSend: function () {
                        $('#submit-button').prop('disabled', true);
                        $('#preloader').removeClass('d-none');
                    },
                    success: function (response) {
                        toastr.success(response.message)
                        location.reload()

                    },
                    error: function (xhr, resp, text) {

                        if (xhr && xhr.responseJSON) {
                            let response = xhr.responseJSON;
                            if (response.status && response.status === "validate_error") {
                                $.each(response.message, function (index, message) {
                                    $("." + message.field).addClass("is-invalid");
                                    $("." + message.field + "_label").addClass("text-danger");
                                    $("." + message.field + "_error").html(message.error);
                                });
                            }
                        }
                    },
                    complete: function (xhr, status) {
                        $('#submit-button').prop('disabled', false);
                        $('#preloader').addClass('d-none');
                    }
                });

            })
        }



        function fetchData(url){
            $.ajax({
                url: window.origin + url,
                type: 'GET',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {
                    if(url === constant.allBlogURL){
                        allBlog(res)
                    }else if(url === constant.singleBlogURL){

                        singleBlog(res)
                    }
                },
                error: function (err){
                    console.log(err)
                }
            })
        }

        $(document).ready(function (){
            if(constant.location === constant.allBlogs){
                fetchData(constant.allBlogURL)
            }
            else if(constant.location === constant.singleBlog){
                fetchData(constant.singleBlogURL)
            }


            $.ajax({
                url: window.origin + '/api/admin/blog/comment/<?= $comment_id?>',
                type: 'GET',
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (res) {

                    blogComment(res)

                },
                error: function (err){
                    console.log(err)
                }
            })
        })


        function blogComment(res){
            res.data.forEach(item => {
                let image = window.origin + '/asset/image/default.jpg'

                    if(item.user.image){
                        image = item.user.image
                    }

                $('#blogCommentList').append(`
                            <ul class="mt-2">
                                <li class="d-flex my-3">
                                    <img style="width: 50px; height: 50px" src="${image}" alt="">

                                    <div class="ms-3">
                                        <h6>${item.user.username ? item.user.username : ''}</h6>
                                        <span id="comments${item.id}">${item.comment_text}</span>
                                    </div>
                                </li>
                            </ul>
            `)
            })

        }
        /**
         * Change the current page title
         * */
        window.location.pathname === '/blogs'? document.title = 'Blog' : ''



    </script>
@endpush
