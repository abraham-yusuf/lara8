<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="aplikasi bengkel shop">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="author" content="">
    <link href="{{ URL::asset('assets/ruangAdmin/img/logo/LOGO_CLS.jfif') }}" rel="icon">
    <title>@yield('title')</title>
    <!-- jquery -->
    <script src="{{ URL::asset('assets/ruangAdmin/vendor/jquery/jquery.min.js') }}"></script>
    <!-- fontawesome -->
    <link href="{{ URL::asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/ruangAdmin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
        type="text/css">
    <!-- ruangadmin -->
    <link href="{{ URL::asset('assets/ruangAdmin/css/ruang-admin.min.css') }}" rel="stylesheet">
    <!-- datatable -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/datatable/css/jquery.dataTables.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link href="{{ URL::asset('assets/select2/css/select2.min.css') }}" rel="stylesheet" />
</head>

<body id="page-top">
