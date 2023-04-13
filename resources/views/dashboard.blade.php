@extends('layouts.adminTemplate',['titre'=>"Accueil"])
@section('autres_style')
<link href="{{asset('assets/css/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen/bootstrap-chosen.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/js/parsley/parsley.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2/select2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap-markdown/bootstrap-markdown.min.css') }}">

@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row m-t-lg">
        <div class="col-lg-12">

            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-creeReunion">
                            Enregistrer participant
                            <span class="label label-warning">Formulaire</span>
                        </a>
                    </li>
                    <li class=""><a data-toggle="tab" href="#tab-listeReunion">
                            Liste des prochaines réunions
                            <span class="label label-warning"></span>
                        </a>
                    </li>
                    <li class=""><a data-toggle="tab" href="#tab-galerie">
                            Marquer la présence
                            <span class="label label-warning"></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-creeReunion">
                        <div class="panel-body">
                            @livewire('participant')
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-listeReunion">
                        <div class="panel-body">
                            <div class="ibox-title">
                                <h5>Cette page affiche toutes les réunions future </h5>
                            </div>
                            <div class="ibox-content">
                                <div class='row'>
                                    <div class=" col-lg-12 col-sm-12">

                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <tbody>
                                                      @forelse ($reunionns as $t)
                                                            <tr>
                                                            <td><a data-toggle="tab" href="#"
                                                                    class="client-link">{{ $t->titre }}</a></td>
                                                            <td> {{ $t->subtitre }}</td>
                                                            <td class="contact-type"><i class="fa fa-clock"> </i>
                                                            </td>
                                                            <td>{{ $t->type }}</td>
                                                            <td>{{ $t->context }}</td>
                                                            <td><span class="label label-info">Participant(s) : {{ $t->participan->count() }}</span></td>
                                                            <td class="client-status text-center"><span
                                                                    class="label label-primary">Date {{ $t->date_debut }}</span>
                                                            </td>
                                                            <td class="client-status text-center">
                                                            <a href="{{ route('viewListe',['id'=>$t->id]) }}"
                                                            class="btn btn-xs btn-outline btn-primary">Liste des participants</a>
                                                            </td>

                                                        </tr>
                                                      @empty
                                                           <span class="label label-danger">Aucune reunion en vue</span>
                                                      @endforelse



                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-galerie">
                        {{-- <div class="panel-body">
                            <div class="ibox-title">
                                <h5>Cette page affiche toutes les réunions</h5>
                            </div>
                            <div class="ibox-content">
                                <div class='row'>
                                    <div class=" col-lg-12 col-sm-12">

                                        <div class="full-height-scroll">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover">
                                                    <tbody>

                                                                        if (!allreunion()) {
                                                                            echo '<span
                                                                                class="label label-danger">Aucune reunion en vue</span>';
                                                                        } else {
                                                            foreach (allreunion() as $t) {
                                                                                                                <tr>
                                                                                                                    <td><a data-toggle="tab" href="#" class="client-link">

                                                                                                                        </a></td>
                                                                                                                    <td>

                                                                switch ($t['type']) {
                                                                    case 0:
                                                                        echo '<span
                                                                                class="label label-danger">Retirer</span>';
                                                                        break;
                                                                    case 1:
                                                                        echo '<span
                                                                                class="label label-warning">En attente</span>';
                                                                        break;

                                                                    default:
                                                                        echo '<span
                                                                                class="label label-success">Publier</span>';
                                                                        break;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="contact-type"><i class="fa fa-clock"> </i>
                                                            </td>
                                                            <td>

                                                            </td>
                                                            <td>

                                                            </td>
                                                            <td class="client-status text-center"><span
                                                                    class="label label-primary">Date
                                                                    :

                                                                </span>
                                                            </td>
                                                            <td>
                                                                <button
                                                                    onclick="supprimer('controller/C_reunion.php',this.title)"
                                                                    title=""
                                                                    class="btn btn-xs btn-outline btn-danger">Supprimer
                                                                    <i class="fa fa-trash"></i> </button>
                                                            </td>

                                                        </tr>




                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

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



    <script src="{{ asset('assets/js/parsley/js/parsley.js') }}"></script>
    <script src="{{ asset('assets/js/parsley/i18n/fr.js') }}"></script>

    <script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function () {
        $('.summernote').summernote();

        $("#formRubrique").on("submit", function (e) {
            e.preventDefault();
            add('#formRubrique','#tab-rubrique','addRubrique')
        });
        $("#formStat").on("submit", function (e) {
            e.preventDefault();
            add('#formStat','#tab-rubrique','addstat')
        });
        $("#formStat2").on("submit", function (e) {
            e.preventDefault();
            add('#formStat2','#tab-rubrique','addstat2')
        });
        $("#formbon").on("submit", function (e) {
            e.preventDefault();
            add('#formbon','#tab-rubrique','addbon')
        });
        $(".select2_cat").select2({
            placeholder: "Choisissez un avocat",
            allowClear: true
        });
    });
    function load(id) {
        $(id).children('.ibox-content').toggleClass('sk-loading');
    }

    function add(form, idLoad, url) {
        var f = form;
        var loade = idLoad;
        var u = url;
        load(loade);
        $.ajax({
            url: u,
            method: "post",
            data: $(f).serialize(),
            success: function (data) {
                load(loade);
                if (!data.reponse) {
                    swal({
                        title: data.msg,
                        icon: 'error'
                    })
                } else {
                    swal({
                        title: data.msg,
                        icon: 'success'
                    })

                    $(f)[0].reset();
                }

            },
        });

    }

    </script>
    @endsection
