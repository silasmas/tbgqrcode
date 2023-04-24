@extends('layouts.tamplate',['titre'=>"Marquer la présence"])
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
{{-- <div class="wrapper wrapper-content animated fadeIn"> --}}
            <div class="middle-box text-center animated fadeInDown">
                <h1>{{ $rep==true?"Réussi":"Echec" }}</h1>
                <h3 class="font-bold"></h3>
                <div class="error-desc">
                    {{ $msg }} <br/>
                    <a href="index.html" class="btn btn-primary m-t">OK</a>
                </div>
            </div>
{{-- </div> --}}
    @endsection
    @section('autres-script')
    <script src="{{ asset('assets/js/bootstrap-markdown/bootstrap-markdown.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-markdown/markdown.js') }}"></script>
    <script src="{{ asset('assets/js/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/chosen/chosen.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/jasny/jasny-bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/instascan.min.js') }}"></script>

    <script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>

    @endsection
