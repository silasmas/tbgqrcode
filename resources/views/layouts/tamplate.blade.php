<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | {{ isset($titre) ? $titre : '' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    <script src="{{ asset('assets/js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    {{-- <link rel="icon" href="{{ asset('assets/img/favicon/android-icon-192x192.png') }}" type="image/rdp-icon"> --}}

    <!-- Styles -->

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/js/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/summernote/summernote.css') }}" rel="stylesheet">
    @livewireStyles
    @yield('autres_style')
</head>

<body class="">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">

                            <li class="{{ Route::current()->getName() == 'dashboard' ? 'active' : '' }}">
                                <a href="{{ route('dashboard') }}">
                                    <span class="nav-label">Accueil</span></a>
                            </li>
                            <li class="{{ Route::current()->getName() == 'reunion' ? 'active' : '' }}"> <a
                                    href="{{ route('reunion') }}"><span class="nav-label">Réunion & Participants</span></a>
                            </li>
                            {{-- <li class="{{ Route::current()->getName() == 'participan' ? 'active' : '' }}">
                                <a href="{{ route('participan') }}">Participans</a>
                            </li> --}}
                            {{-- <li class="{{ Route::current()->getName() == 'G_carthographie' ? 'active' : '' }}">
                                <a href="{{ route('G_carthographie') }}">Users</a>
                            </li> --}}
                            {{-- <li class="{{ Route::current()->getName() == 'scanner' ? 'active' : '' }}">
                                <a href="{{ route('scanne') }}">Scanner</a>
                            </li> --}}
                            <li class="{{ Route::current()->getName() == 'agent' ? 'active' : '' }}">
                                <a href="{{ route('agent') }}">Users</a>
                            </li>

                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i
                                class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            {{-- <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control"
                                    name="top-search" id="top-search">
                            </div> --}}
                        </form>
                    </div>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{ $titre }}</h2>
                </div>
            </div>

            @yield('content')

            <div class="footer">
                <div class="pull-right">

                </div>
                <div>
                    <a href='silasdev.com'> <strong>Copyright</strong> SDev &copy; 2023</a>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('assets/js/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('assets/js/inspinia.js') }}"></script>
    <script src="{{ asset('assets/js/pace/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/pace/pace.min.js') }}"></script>

    <script src="{{ asset('assets/js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/summernote/summernote.min.js') }}"></script>

    @livewireScripts
    @yield('autres-script')
    <script>
        window.addEventListener('swal:modal', event => {
            swal({
                title: event.detail.titre,
                text: event.detail.text,
                icon: event.detail.type,
            });
        });
        window.addEventListener('swal:confirm', event => {
            swal({
                title: event.detail.titre,
                text: event.detail.text,
                icon: event.detail.type,
                dangerMode: true,
                buttons: {
                    cancel: 'Non',
                    delete: 'OUI'
                }
            }).then(function(willDelete) {
                if (willDelete) {
                    switch (event.detail.from) {
                        case 'Monpanier':
                            window.livewire.emit('removeCardeMonPanier', event.detail.id);
                            break;
                        case 'panier':

                            window.livewire.emit('removeCarde', event.detail.id);
                            break;
                        case 'Detail':

                            window.livewire.emit('ajoutCardsDetail', event.detail.id);
                            break;

                        default:
                            break;
                    }
                }

            });
        });
        function add(form, idLoad, url) {
        var f = form;
        var loade = idLoad;
        var u = url;
        $.ajax({
            url: u,
            method: "post",
            data: $(f).serialize(),
            success: function (data) {
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
                    actualiser();
                }

            },
        });

    }
        function deleter(id, url) {

            swal({
                title: "Attention suppression",
                text: "Etes -vous prêt de supprimer cette information?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                    cancel: 'Non',
                    delete: 'OUI'
                }
            }).then(function(willDelete) {
                if (willDelete) {

                    $.ajax({
                        url: url + "/" + id,
                        method: "GET",
                        data: {
                            'idv': id
                        },
                        success: function(data) {
                            //  load('#tab-session');
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
                                actualiser();
                            }
                        },
                    });
                } else {
                    swal({
                        title: "Suppression annuler",
                        icon: 'error'
                    })
                }
            });
        }
        function actualiser() {
        location.reload();
    }
    </script>
</body>

</html>
