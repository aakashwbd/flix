<?php
    $currentControllerName = Request::segment(1);
    $currentFullRouteName = Route::getFacadeRoot()
        ->current()
        ->uri();
?>

<nav id="siteNav" class="">
    <div class="container">
        <a href="{{url('/')}}">
            <img id="navLogo" class="logo" src="{{asset('images\default.png')}}" alt="logo">
        </a>

        <button id="navbar-toggler-btn" class="btn btn-outline-secondary nav-toggler">
            <span class="iconify cursor-pointer nav-toggler" id="" data-icon="gg:menu" data-width="25" data-height="25"></span>
        </button>


        <ul id="siteNav-list" class="list">
            <li class="list-item">
                <a href="{{url('/')}}" class="list-link {{ $currentFullRouteName == '/' || '' ? 'active' : '' }}">members</a>
            </li>

            <li class="list-item">
                <a href="{{url('/ads')}}" class="list-link {{ $currentControllerName == 'ads' || '' ? 'active' : '' }}">ads</a>
            </li>

            <li class="list-item">
                <a href="{{url('/live')}}" class="list-link {{ $currentControllerName == 'live' || '' ? 'active' : '' }}">live</a>
            </li>

            <li class="list-item">
                <a href="{{url('/videos')}}" class="list-link {{ $currentControllerName == 'videos' || '' ? 'active' : '' }}">videos</a>
            </li>

            <li class="list-item">
                <a href="{{url('/maps')}}" class="list-link {{ $currentControllerName == 'maps' || '' ? 'active' : '' }}">maps</a>
            </li>

            <li class="list-item">
                <a href="{{url('/blogs?tab=blogs')}}" class="list-link {{ $currentControllerName == 'blogs' || '' ? 'active' : '' }}">blogs</a>
            </li>

            <li class="list-item">
                <a href="{{url('/package')}}" class="list-link {{ $currentControllerName == 'package' || '' ? 'active' : '' }}">packages</a>
            </li>

            <li class="list-item" id="inscriptionNavItem">
                <a href="{{url('/inscription')}}" class="list-link {{ $currentControllerName == 'inscription' || '' ? 'active' : '' }}">inscriptions</a>
            </li>

            <li class="list-item" id="connectionNavItem">
                <a href="javaScript:void(0)" data-bs-toggle="modal" data-bs-target="#loginModal" class="list-link">connections</a>
            </li>

            <li class="list-item d-none" id="graph">
                <a href="{{url('/graph?tab=visitor')}}" class="list-link {{ $currentControllerName == 'graph' || '' ? 'active' : '' }}">
                    <span class="iconify" data-icon="bi:flag" data-width="20" data-height="20"></span>
                </a>
            </li>

            <li class="list-item dropdown d-none" id="message" >
                <a href="#" class="list-link " data-bs-toggle="dropdown">
                    <span class="iconify" data-icon="bx:message-rounded" data-width="20" data-height="20"></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end" style="width: 350px" id="shortMessage"></ul>
            </li>

            <li class="list-item dropdown d-none" id="profileNavItem">
                <a class="list-link" href="#" data-bs-toggle="dropdown">
                    <img id="navbarProfileImg" class="avatar-sm rounded-circle"
                         src=""
                         alt="">
                </a>

                <ul class="dropdown-menu-end dropdown-menu text-center">
                    <li class="border-bottom py-2">
                        <a href="{{url('profile?tab=information')}}" class="dropdown-item text-capitalize">edit my profile</a>
                    </li>
{{--                    <li class="border-bottom py-2">--}}
{{--                        <a href="" class="dropdown-item text-capitalize">show</a>--}}
{{--                    </li>--}}
                    <li class="border-bottom py-2">
                        <a href="{{url('profile?tab=photos')}}" class="dropdown-item text-capitalize">photos/videos</a>
                    </li>
                    <li class="border-bottom py-2">
                        <a href="{{url('profile?tab=setting')}}" class="dropdown-item text-capitalize">setting</a>
                    </li>
                    <li class="border-bottom py-2">
                        <a href="{{url('profile?tab=favorite')}}" class="dropdown-item text-capitalize">favorite</a>
                    </li>
                    <li class="border-bottom py-2">
                        <a href="{{url('profile?tab=blacklist')}}" class="dropdown-item text-capitalize">block list</a>
                    </li>
                    <li class=" py-2">
                        <a href="{{url('profile?tab=premium')}}" class="dropdown-item text-capitalize">premium access</a>
                    </li>
{{--                    <li class="">--}}
{{--                        <a href="{{url('profile?tab=invisible')}}" class="dropdown-item text-capitalize">become invisible</a>--}}
{{--                    </li>--}}
                </ul>
            </li>

            <li class="list-item dropdown d-none" id="moreMenuDots">
                <a class="list-link" href="" data-bs-toggle="dropdown">
                        <span class="iconify" data-icon="bx:dots-vertical-rounded" data-width="25"
                              data-height="25"></span>
                </a>

                <ul class="dropdown-menu-end dropdown-menu text-center">
                    <li class="border-bottom py-2">
                        <a href="{{url('/about')}}" class="dropdown-item text-capitalize">about</a>
                    </li>
                    <li class="border-bottom py-2">
                        <a href="{{url('/blogs?tab=blogs')}}" class="dropdown-item text-capitalize">blog</a>
                    </li>
                    <li class="border-bottom py-2">
                        <a href="{{url('/information?tab=faq')}}" class="dropdown-item text-capitalize">help</a>
                    </li>
                    <li class="border-bottom py-2">
                        <a href="#" data-bs-target="#contactModal" data-bs-toggle="modal" class="dropdown-item text-capitalize">contact</a>
                    </li>
                    <li class="border-bottom py-2">
                        <a href="{{url('/information?tab=legal')}}" class="dropdown-item text-capitalize">legal notice</a>
                    </li>
                    <li class="">
                        <a href="#" class="dropdown-item text-capitalize" id="signOut">disconnect</a>
                    </li>
                </ul>
            </li>

        </ul>


    </div>
</nav>



@push('custom-js')
    <script>

        $("#navbar-toggler-btn").on("click", function () {
            $("#siteNav-list").toggleClass("nav-show");
        });

        $(document).ready(function (){
            let constant = {
                token: localStorage.getItem('accessToken'),
                userInfo: JSON.parse(localStorage.getItem('user')),
                moreItem: {
                    profileNavItem: document.getElementById('profileNavItem'),
                    defaultImage: "{{asset('images/Default_Image_Thumbnail.png')}}",
                    moreMenuDots: document.getElementById('moreMenuDots'),
                    graph: document.getElementById('graph'),
                    message: document.getElementById('message'),
                    inscriptionNavItem: document.getElementById('inscriptionNavItem'),
                    connectionNavItem:  document.getElementById('connectionNavItem'),
                    navbarProfileImg: document.getElementById('navbarProfileImg')
                }
            }

            if(constant.token){
                Object.keys(constant.moreItem).forEach(item => {
                    if(item === 'connectionNavItem'){
                        $('#'+item).addClass('d-none')
                    }else if(item === 'inscriptionNavItem'){
                        $('#'+item).addClass('d-none')
                    }else if(item === 'navbarProfileImg'){
                        let user = constant.userInfo

                        if(typeof user === 'string'){
                            user = JSON.parse(constant.userInfo.replaceAll('&quot;', '"'))
                        }

                        let img = constant.moreItem.defaultImage

                        if(user.image){
                            img= user.image
                        }

                        $('#'+item).attr('src', img)
                    }else{
                        $('#'+item).removeClass('d-none')
                    }
                })


                $.ajax({
                    type: 'GET',
                    url: window.origin + '/api/short-messages',
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        "Authorization": constant.token,
                    },
                    success: function (response) {

                        if(response.status === 'success' && response.data.length > 0){
                            response.data.forEach((item, number)=>{

                                $('#shortMessage').append(`
                                    <li class="dropdown-item border-bottom py-1">
                                         <div class="d-flex">
                                            <img style="width: 40px; height: 40px" class="me-2" src="${item.user.image ?  item.user.image : window.origin + '/asset/image/default.jpg'}"/>
                                                <div>
                                                     <p>${item.user.username ? item.user.username : ''}</p>
                                                     <p class='d-block'>${item.messages}</p>
                                                </div>
                                         </div>
                                    </li>

                                    ${number === 4 ? (`
                                         <li class="dropdown-item py-1 text-center">
                                              <span>Your latest conversation</span>
                                        </li>

                                    `): '' }
                                `)
                            })
                        }else{
                            $('#shortMessage').append(`
                                <li class="dropdown-item">
                                        Please, conversation first
                                </li>
                        `)
                        }


                    },
                    error: function (xhr, resp, text) {
                        console.log(xhr);

                    }
                });
            }
        })


        // messengerOpenHandlder = function (from_user_id, to_user_id){
        //     console.log(from_user_id, to_user_id)
        //
        //     $("#messenger" + to_user_id).removeClass("d-none");
        // }
        // onclick="messengerOpenHandlder(${item.from_user}, ${item.to_user})"

    </script>
@endpush




