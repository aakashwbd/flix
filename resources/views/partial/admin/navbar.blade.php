<?php
    $currentControllerName = Request::segment(1);
    $currentControllerName2 = Request::segment(2);
    $currentFullRouteName = Route::getFacadeRoot()
        ->current()
        ->uri();

?>

<aside class="sidebar">

    <div id="dashboard-toggle-button" class="toggle-button">
        <span class="iconify toggle-back-icon" data-icon="fluent:text-grammar-arrow-right-24-filled" data-width="20" data-height="20"></span>

        <span class="iconify toggle-forward-icon" data-icon="fluent:text-grammar-arrow-left-24-filled" data-width="20" data-height="20"></span>
    </div>

    <div class="d-flex justify-content-center align-items-center">
        <img id="adminPanelLogo" src="{{asset('asset/image/default.jpg')}}" class="logo-lg avatar-sm-2 rounded-circle" alt="logo-lg">
    </div>

    <ul class="list">
        <li class="list-item  my-3">
            <a
                href="{{url('/admin')}}"
                class="list-link
                    {{$currentFullRouteName == 'admin' || '' ? 'active' : '' }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Dashboard"
            >
                <span
                    class="iconify me-2 list-icon"
                    data-icon="ic:sharp-space-dashboard"
                    data-width="20"
                    data-height="20"></span>
                <span
                    class="list-title"
                >
                    dashboard
                </span>
            </a>
        </li>

        <li class="list-item list-heading">Manage</li>
        <li class="list-item  my-3">
            <a  data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Category"
                href="{{url('/admin/category')}}"
                class="list-link {{$currentControllerName2 == 'category' || '' ? 'active' : '' }}">
                <span class="iconify me-2 list-icon"  data-icon="material-symbols:category-outline" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                          Category
                </span>
            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Blog"
               href="{{url('/admin/blog')}}" class="list-link {{$currentControllerName2 == 'blog' || '' ? 'active' : '' }}">
                <span class="iconify me-2 list-icon"  data-icon="fa6-brands:blogger-b" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                            Blog
                </span>

            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Banner Image"
               href="{{url('/admin/banner-image')}}" class="list-link {{$currentControllerName2 == 'banner-image' || '' ? 'active' : '' }}">
                <span class="iconify me-2 list-icon" data-icon="bi:image" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                             Banner Image
                </span>

            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Flash"
               href="{{url('/admin/flash')}}" class="list-link {{$currentControllerName2 == 'flash' || '' ? 'active' : '' }}">
                <span class="iconify me-2 list-icon" data-icon="carbon:flash-filled" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                                 Flash
                </span>
            </a>
        </li>




        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Verification Requests"
               href="{{url('/admin/verification')}}" class="list-link {{$currentControllerName2 == 'verification' || '' ? 'active' : '' }}">
                <span class="iconify me-2 list-icon" data-icon="uiw:verification" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                     Verification Requests
                </span>

            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Reports"
               href="{{url('/admin/report')}}" class="list-link {{$currentControllerName2 == 'report' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2" data-icon="ic:round-report" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                  Reports
                </span>

            </a>
        </li>
        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Verification"
               href="{{url('/admin/invite-code')}}" class="list-link {{$currentControllerName2 == 'invite-code' || '' ? 'active' : '' }}">
                <span class="iconify me-2 list-icon"data-icon="ic:sharp-space-dashboard" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                                  Invitation Code
                </span>
            </a>
        </li>

{{--        <li class="list-item  my-3">--}}
{{--            <a href="{{url('/admin/invite-code')}}" class="list-link {{$currentControllerName2 == 'invite-code' || '' ? 'active' : '' }}">--}}
{{--                <span class="iconify me-2" data-icon="ic:sharp-space-dashboard" data-width="20"--}}
{{--                      data-height="20"></span>--}}
{{--                Invitation Code--}}
{{--            </a>--}}
{{--        </li>--}}

        <li class="list-item  my-3">
            <a
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Package"
                href="{{url('/admin/package')}}" class="list-link {{$currentControllerName2 == 'package' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2" data-icon="mdi:package-variant-plus" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                   Package
                </span>

            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Recent Payment"
                href="{{url('/admin/recent-payment')}}" class="list-link {{$currentControllerName2 == 'recent-payment' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2" data-icon="material-symbols:payments-outline-rounded" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                    Recent Payment
                </span>

            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Clean Video" href="{{url('/admin/video')}}" class="list-link {{$currentControllerName2 == 'video' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2"  data-icon="bxs:video"  data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                          Clean Video
                </span>

            </a>
        </li>

        <li class="list-item list-heading">Administration</li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Manage Admin"
               href="{{url('/admin/manage-admin')}}" class="list-link {{$currentControllerName2 == 'manage-admin' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2"  data-icon="clarity:administrator-solid" data-width="20"
                      data-height="20"></span>

                <span class="list-title">
                             Manage Admin
                </span>
            </a>
        </li>

        <li class="list-item list-heading">Users</li>
        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Manage Users"
               href="{{url('/admin/manage-users')}}" class="list-link {{$currentControllerName2 == 'manage-users' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2"  data-icon="clarity:administrator-solid" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                       Manage Users
                </span>

            </a>
        </li>
        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Banned Users"
               href="{{url('/admin/banned-users')}}"  class="list-link {{$currentControllerName2 == 'banned-users' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2"  data-icon="clarity:administrator-solid" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                  Banned Users
                </span>

            </a>
        </li>

        <li class="list-item list-heading">Setting</li>
        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Basic Setting" href="{{url('/admin/settings')}}" class="list-link {{$currentControllerName2 == 'settings' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2" data-icon="ant-design:setting-filled" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
            Basic Setting
                </span>

            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Notification"
               href="{{url('/admin/notification')}}" class="list-link {{$currentControllerName2 == 'notification' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2" data-icon="bi:bell-fill" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                    Notification
                </span>

            </a>
        </li>

        <li class="list-item  my-3">
            <a data-bs-toggle="tooltip"
               data-bs-placement="top"
               title="Notification"
               href="{{url('/admin/smtp')}}" class="list-link {{$currentControllerName2 == 'smtp' || '' ? 'active' : '' }}">
                <span class="iconify list-icon me-2"  data-icon="ant-design:cloud-server-outlined" data-width="20"
                      data-height="20"></span>
                <span class="list-title">
                    SMTP
                </span>
            </a>
        </li>

    </ul>
</aside>

@push('custom-js')
    <script>
        const variables = {
            body: document.getElementById('admin-main'),
            siteBar: document.getElementById('dashboard-toggle-button'),
        }

        if(variables.body){
            if(variables.siteBar){
                variables.siteBar.addEventListener('click', ()=>{
                    variables.body.classList.toggle('compact')
                })
            }


        }
    </script>
@endpush




