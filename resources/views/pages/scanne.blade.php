@extends('layouts.adminTemplate',['titre'=>"Réunion"])
@section('autres_style')
<link href="{{asset('assets/css/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen/bootstrap-chosen.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/js/parsley/parsley.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-markdown/bootstrap-markdown.min.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/phpqrcode/qrlib.php') }}"> --}}

@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row m-t-lg">

        <div class="col-lg-12">
            {{-- {{ QRcode::png("https://beraca.hardymuanda.com/qreunion.php?reunion=1") }} --}}
{{-- <img src="data:image/png;base64,{{ base64_encode(QrCode::size(300)->format("png")
        ->format("png")
        ->merge("{{ asset('assets/img/logo.png') }}", 0.1, true)
    ->generate("https://beraca.hardymuanda.com/qreunion.php?reunion=1")) }}" alt="" srcset=""> --}}
        </div>
    </div>
    @endsection
    @section('autres-script')
    <script src="{{ asset('assets/js/bootstrap-markdown/bootstrap-markdown.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-markdown/markdown.js') }}"></script>
    <script src="{{ asset('assets/js/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/jasny/jasny-bootstrap.min.js') }}"></script>


    <script src="{{ asset('assets/js/parsley/js/parsley.js') }}"></script>
    <script src="{{ asset('assets/js/parsley/i18n/fr.js') }}"></script>

    <script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>

    @endsection
