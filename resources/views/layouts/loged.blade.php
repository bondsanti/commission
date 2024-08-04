<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Nuttapong Sawasdee | Vbeyond" name="author" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <title>VBEYOND | @yield('title')</title>

    <!-- Scripts -->


    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    {{-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> --}}

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script> --}}

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}



    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">


    <link href="{{ asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet">

    <script src="{{ asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" defer></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" defer></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script> --}}
    <link href="{{ asset('assets/css/default/style.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <script src="{{ asset('js/custom.js') }}"></script>

    <!-- js tree -->

    {{-- <script src="{{ asset('js/jquery-simple-tree-table.js')}}"></script> --}}
    {{-- <link type="text/css" href="{{ asset('css/csstree/jquery.tbltree.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/csstree/stylesheets/styles.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/csstree/stylesheets/pygment_trac.css') }}"> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}

    @stack('css')
    <link href="{{ asset('assets/plugins/datatables/css/dataTables.bootstrap4.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables/css/responsive/responsive.bootstrap4.css') }}" rel="stylesheet" />

    <script>
        $(function() {
            var totalSum = 0;
            var
                $table = $('#tree-table'),
                rows = $table.find('tr');

            rows.each(function(index, row) {
                var
                    $row = $(row),
                    level = $row.data('level'),
                    id = $row.data('id'),
                    $columnName = $row.find('div[data-column="name"]'),
                    //$columnTotal = $row.find('div[data-column="total"]'),
                    children = $table.find('tr[data-parent="' + id + '"]');

                if (children.length) {
                    var expander = $columnName.prepend(
                        '<i class="treegrid-expander fas fa-plus fa-lg"></i>');
                    //var totalchildren = $columnTotal.prepend(children.length);
                    children.hide();
                    //console.log(children.length);
                    expander.on('click', function(e) {
                        var $target = $(e.target);
                        if ($target.hasClass('fas fa-plus fa-lg')) {
                            $target
                                .removeClass('fas fa-plus fa-lg')
                                .addClass('fas fa-minus fa-lg');
                            children.show();
                        } else {
                            $target
                                .removeClass('fas fa-minus fa-lg')
                                .addClass('fas fa-plus fa-lg');

                            reverseHide($table, $row);
                        }
                    });
                }
                // totalSum +=children.length;
                // console.log(totalSum);
                $columnName.prepend('' +
                    '<span class="treegrid-indent" style="width:' + 15 * level + 'px"></span>' +
                    '');
            });

            // Reverse hide all elements
            reverseHide = function(table, element) {
                var
                    $element = $(element),
                    id = $element.data('id'),
                    children = table.find('tr[data-parent="' + id + '"]');

                if (children.length) {
                    children.each(function(i, e) {
                        reverseHide(table, e);
                    });

                    $element
                        .find('fas fa-minus fa-lg')
                        .removeClass('fas fa-plus fa-lg')
                        .addClass('fas fa-plus fa-lg');

                    children.hide();
                }
            };
        });
    </script>
</head>

<body>
    @if (session('status'))
        <div class="alert alert-success flash-status" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div id="app">
        {{-- @include('component.page-loader') --}}
        <nav class="navbar navbar-expand-md navbar-dark bg-primary navbar-laravel">
            <div class="" style="display:contents">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @if (Auth::user()->role()->name == 'Team Leader')
                        VBEYOND | Partner Lead
                    @else
                        VBEYOND | Commission
                    @endif

                    {{-- <img src="{{asset('/assets/images/logo-dynamic.png')}}" alt=""> --}}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>




                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if (Auth::user()->role()->name != 'Admin' && Auth::user()->role()->name != 'Account' && Auth::user()->role()->IN == 1)
                                    ( {{ Auth::user()->commission_point }} points )
                                @endif
                                {{ Auth::user()->name_th }} ( {{ Auth::user()->role()->name }} )
                                <span class="caret"></span>
                            </a>

                            <div class="d-block d-sm-none">
                                @if (Auth::user()->role()->name != 'Team Leader')
                                    
                               
                                <a href="{{ route('dashboard') }}" class="dropdown-item text-white">Dashboard</a>
                                <a href="{{ route('users.index') }}" class="dropdown-item text-white">Sales</a>

                                <a href="{{ route('promotions.index') }}"
                                    class="dropdown-item text-white ">Promotions</a>
                                <a href="{{ route('projects.index') }}" class="dropdown-item text-white">Projects</a>
                                <a href="{{ route('calendars.index') }}" class="dropdown-item text-white ">Calendar</a>


                                <a href="{{ route('lists.index') }}" class="dropdown-item text-white ">Report</a>
                                <a href="{{ route('commissions.index') }}"
                                    class="dropdown-item text-white ">Commissions</a>

                                @if (Auth::user()->role()->name == 'Admin')
                                    <a href="{{ route('roles.index') }}"
                                        class="dropdown-item text-white ">Positions</a>
                                    <a href="{{ route('teams.index') }}" class="dropdown-item text-white ">Teams</a>
                                    <a href="{{ route('settings.index') }}"
                                        class="dropdown-item text-white ">Setting</a>
                                @endif
                                @endif
                                <a href="{{ route('lists.index') }}" class="dropdown-item text-white">รายการ</a>
                            </div>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->role()->OUT == 1)
                                    <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }} ">Profile</a>
                                @elseif(Auth::user()->role()->IN == 1)
                                    <a class="dropdown-item"
                                        href="{{ route('salein.edit', Auth::id()) }} ">Profile</a>
                                @endif
                                @if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminAgent')
                                    <a class="dropdown-item" href="{{ route('linkgis') }}" target="_blank">Link
                                        Register</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <main class="">
            <div class="row m-0">
                <div class="col-lg-2 bg-white shadow-sm p-0 col-sm-2 d-none d-sm-block"
                    style="height:100vh;overflow-y:auto;">
                    @include('layouts.sidebar')
                </div>
                <div class="col-lg-10 py-4 col-sm-10" id="content">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo/table-manage-default.demo.min.js') }}"></script>
    {{-- <script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js">
    </script> --}}
    @stack('scripts')
</body>

</html>
