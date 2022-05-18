
<script src="{{asset('asset/vendor/jquery/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
{{--<script src="{{asset('asset\vendor\bootstrap\js\bootstrap.min.js')}}"></script>--}}
<script src="{{asset('asset/vendor/Minimalist-jQuery-Plugin-For-Birthday-Selector-DOB-Picker/dobpicker.js')}}"></script>
<script src="{{asset('asset/vendor/toastr/toastr.js')}}"></script>
<script src="{{asset('asset/vendor/ImagesLoader-main/jquery.imagesloader-1.0.1.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.serializeJSON/3.2.1/jquery.serializejson.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

<script>




    let constant = {
        token: localStorage.getItem('adminAccess'),
        currentPath: window.location.pathname,
        loginURL: window.origin + '/admin/auth/login',
        adminURL: window.origin + '/admin',
        getAdmin: JSON.parse(localStorage.getItem('adminInfo')),
    }

    function authRestrictionHandler (){
        if(!constant.token){
            window.location.replace(constant.loginURL);
        }
    }

    function signOut(){
        // alert(constant.getAdmin)
        localStorage.removeItem('adminAccess');
        localStorage.removeItem('adminInfo');
        window.location.replace(constant.loginURL);
    }


    $(document).ready(function (){
        if(constant.getAdmin){
            $('#adminImage').attr('src', constant.getAdmin.image)
            $('#adminName').text(constant.getAdmin.name)
        }
    })



</script>


@stack('custom-js')



</body>
</html>
