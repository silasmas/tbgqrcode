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
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row m-t-lg">
        <div class="col-lg-12">
            <div class="tabs-container">
                <h3>Video scanne</h3>
                <video id="preview"></video>
            </div>
        </div>
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

    <script src="{{ asset('assets/js/instascan.min.js') }}"></script>

    <script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        scanner.addListener('scan', function (content) {
          console.log(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
          if (cameras.length > 0) {
            scanner.start(cameras[0]);
          } else {
            console.error('No cameras found.');
          }
        }).catch(function (e) {
          console.error(e);
        });
      </script>
    @endsection
