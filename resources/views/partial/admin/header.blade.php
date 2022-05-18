<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <!-- ***** Vendor CSS File ***** -->
    <link rel="stylesheet" href="{{asset('asset/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/vendor/toastr/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('asset/vendor/ImagesLoader-main/jquery.imagesloader.css')}}">

    <!-- ***** CDN CSS Links ***** -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!-- ***** datatablesLinks ***** -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <!-- ***** Main CSS File ***** -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

</head>
<body id="admin-main">


<div id="preloader" class="d-none">
    <div id="status">
    </div>
</div>

<script>
    let preLoader = document.getElementById('preloader')

    preLoader.classList.remove('d-none')

    setTimeout(function(){
        preLoader.classList.add('d-none')
    }, 5000);
</script>
