@extends('layouts.adminTemplate',['titre'=>"Réunion"])
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
            @if (session()->has('message'))
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-{{session()->get('type') }} alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    {{ session()->get('message') }}
                </div>
            </div>
        @endif
        </div>
        <div class="col-lg-12">

            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-creeReunion">
                            Crée une réunion
                            <span class="label label-warning">Formulaire</span>
                        </a>
                    </li>
                    <li class=""><a data-toggle="tab" href="#tab-futurReunion">
                            Liste des réunions
                            <span class="label label-warning"></span>
                        </a>
                    </li>
                    <li class=""><a data-toggle="tab" href="#tab-participants">
                            Liste des participants
                            <span class="label label-warning"></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-creeReunion">
                        <div class="panel-body">
                            <div class="col-lg-offset-1 col-lg-10 col-sm-12">
                                <div class="ibox" id="tabCat">
                                    <div class="ibox-title">
                                        <h5>
                                            {{ isset($categorie) ? 'Ce formulaire vous permet de modifier une actualité' : 'Ce formulaire vous permet de crée une actualité' }}
                                        </h5>
                                    </div>
                                    <div class="ibox-content" id="tab-rubrique">
                                        <div class="sk-spinner sk-spinner-wandering-cubes">
                                            <div class="sk-cube1"></div>
                                            <div class="sk-cube2"></div>
                                        </div>
                                        <div class='row'>
                                            <div class=" col-lg-12 col-sm-12">
                                                <form method="POST" class="form-group"
                                                        action="{{route('add.reunion') }}" enctype="multipart/form-data" data-parsley-validate>
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Titre </label>
                                                            <input type="text" hidden
                                                                value="{{ isset($categorie) ? $categorie->id : '' }}"
                                                                name="idslide"  />
                                                            <input type="text" placeholder="Titre"
                                                                class="form-control" name='titre'
                                                                value="" required>

                                                        </div>
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Sous-titre</label>
                                                            <input type="text" placeholder="Sous titre"
                                                                class="form-control" name='subtitre'  required>
                                                        </div>
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Forme de la réunion</label>
                                                            <input type="text" placeholder="Forme (Présencielle, en ligne...)"
                                                                class="form-control" name='type'   required>
                                                        </div>
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Contexte</label>
                                                            <input type="text" placeholder="Contexte (MasterClasse...)"
                                                                class="form-control" name='contexte'>
                                                        </div>
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Date debut</label>
                                                            <input type="date" placeholder="Date"
                                                                class="form-control" name='date_debut'>
                                                        </div>
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Date Fin</label>
                                                            <input type="date" placeholder="Date fin"
                                                                class="form-control" name='date_fin'>
                                                        </div>
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Quota</label>
                                                            <input type="number" placeholder="Quota (Nombre Max de personne)"
                                                                class="form-control" name='quota'>
                                                        </div>
                                                        <div class="col-lg-6 form-group ">
                                                            <label>Status</label>
                                                            <select class=" form-control" name="status" required>
                                                                <option value="" disabled selected>Selectionnez un status</option>
                                                                    <option value="Ouvert">Ouvert</option>
                                                                    <option value="En attente">En attente</option>
                                                                    <option value="Fermee">Fermée</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-12 form-group">
                                                            <label>Image</label>
                                                            <div class=" fileinput fileinput-new input-group"
                                                                data-provides="fileinput">
                                                                <div class="form-control"
                                                                    data-trigger="fileinput">
                                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                                    <span class="fileinput-filename"></span>
                                                                </div>
                                                                <span
                                                                    class="input-group-addon btn btn-default btn-file"><span
                                                                        class="fileinput-new">cover</span>
                                                                    <span class="fileinput-exists">Changer</span>
                                                                    <input type="file" name="image"  required></span>
                                                                <a href="#"
                                                                    class="input-group-addon btn btn-default fileinput-exists"
                                                                    data-dismiss="fileinput">Supprimer</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-offset-3 col-lg-6 col-sm-12 form-group">
                                                            <div class="col-sm-offset-4 col-sm-5">
                                                                <button class="ladda-button btn btn-sm btn-primary"
                                                                    type="submit">
                                                                    <i class="fa fa-spinner fa-send"></i>  Enregistrer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-futurReunion">
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
                                                        @forelse ($reunions as $t)
                                                        <tr>
                                                        <td><a data-toggle="tab" href="#"
                                                                class="client-link">{{ $t->titre }}</a></td>
                                                        <td> {{ $t->subtitre }}</td>
                                                        <td class="contact-type"><i class="fa fa-clock"> </i>
                                                        </td>
                                                        <td>{{ $t->type }}</td>
                                                        <td>{{ $t->context }}</td>
                                                        <td><span class="label label-info">Participant(s) : {{ $t->participan->count() }}</span></td>
                                                        <td class="client-status text-center">
                                                            <span class="label {{ $t->date_fin> now()?"label-primary":"label-danger" }}">Date {{ $t->date_fin> now()?$t->date_debut :"La réunion est déjà passée"}}</span>
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
                    <div class="tab-pane" id="tab-participants">
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
                                                        @forelse ($participan as $t)
                                                        <tr>
                                                        <td><a data-toggle="tab" href="#"
                                                                class="client-link">{{ $t->nom." ".$t->prenom." ".$t->postnom }}</a></td>
                                                        <td> {{ $t->sexe }}</td>
                                                        <td class="contact-type"><i class="fa fa-clock"> </i>
                                                        </td>
                                                        <td>{{ $t->phone }}</td>
                                                        <td>{{ $t->email }}</td>
                                                        <td><span class="label label-info">Réunion(s) : {{ $t->reunion->count() }}</span></td>
                                                        {{-- <td class="client-status text-center">
                                                            <span class="label {{ $t->date_fin> now()?"label-primary":"label-danger" }}">Date {{ $t->date_fin> now()?$t->date_debut :"La réunion est déjà passée"}}</span>
                                                        </td> --}}
                                                        <td class="client-status text-center">
                                                        <a href="{{ route('viewListeReunion',['id'=>$t->id]) }}"
                                                        class="btn btn-xs btn-outline btn-primary">Liste des réunions participée</a>
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
