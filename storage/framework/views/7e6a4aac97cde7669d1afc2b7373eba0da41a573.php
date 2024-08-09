<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="Nuttapong Sawasdee | Vbeyond" name="author" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <title>VBEYOND | <?php echo $__env->yieldContent('title'); ?></title>

    <!-- Scripts -->


    <!-- Fonts -->
    
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    

    <script src="<?php echo e(asset('js/jquery-3.3.1.min.js')); ?>"></script>
    

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    



    <link href="<?php echo e(asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet">


    <link href="<?php echo e(asset('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>"
        rel="stylesheet">

    <script src="<?php echo e(asset('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>" defer></script>

    
    <link href="<?php echo e(asset('assets/css/default/style.min.css')); ?>" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

    <!-- js tree -->

    
    
    
    

    <?php echo $__env->yieldPushContent('css'); ?>
    <link href="<?php echo e(asset('assets/plugins/datatables/css/dataTables.bootstrap4.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('assets/plugins/datatables/css/responsive/responsive.bootstrap4.css')); ?>" rel="stylesheet" />

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
    <?php if(session('status')): ?>
        <div class="alert alert-success flash-status" role="alert">
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>
    <div id="app">
        
        <nav class="navbar navbar-expand-md navbar-dark bg-primary navbar-laravel">
            <div class="" style="display:contents">
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    <?php if(Auth::user()->role()->name == 'Team Leader'): ?>
                        VBEYOND | Partner Lead
                    <?php else: ?>
                        VBEYOND | Commission
                    <?php endif; ?>

                    
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="<?php echo e(__('Toggle navigation')); ?>">
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
                                <?php if(Auth::user()->role()->name != 'Admin' && Auth::user()->role()->name != 'Account' && Auth::user()->role()->IN == 1): ?>
                                    ( <?php echo e(Auth::user()->commission_point); ?> points )
                                <?php endif; ?>
                                <?php echo e(Auth::user()->name_th); ?> ( <?php echo e(Auth::user()->role()->name); ?> )
                                <span class="caret"></span>
                            </a>

                            <div class="d-block d-sm-none">
                                <?php if(Auth::user()->role()->name != 'Team Leader'): ?>
                                    
                               
                                <a href="<?php echo e(route('dashboard')); ?>" class="dropdown-item text-white">Dashboard</a>
                                <a href="<?php echo e(route('users.index')); ?>" class="dropdown-item text-white">Sales</a>

                                <a href="<?php echo e(route('promotions.index')); ?>"
                                    class="dropdown-item text-white ">Promotions</a>
                                <a href="<?php echo e(route('projects.index')); ?>" class="dropdown-item text-white">Projects</a>
                                <a href="<?php echo e(route('calendars.index')); ?>" class="dropdown-item text-white ">Calendar</a>


                                <a href="<?php echo e(route('lists.index')); ?>" class="dropdown-item text-white ">Report</a>
                                <a href="<?php echo e(route('commissions.index')); ?>"
                                    class="dropdown-item text-white ">Commissions</a>

                                <?php if(Auth::user()->role()->name == 'Admin'): ?>
                                    <a href="<?php echo e(route('roles.index')); ?>"
                                        class="dropdown-item text-white ">Positions</a>
                                    <a href="<?php echo e(route('teams.index')); ?>" class="dropdown-item text-white ">Teams</a>
                                    <a href="<?php echo e(route('settings.index')); ?>"
                                        class="dropdown-item text-white ">Setting</a>
                                <?php endif; ?>
                                <?php endif; ?>
                                <a href="<?php echo e(route('lists.index')); ?>" class="dropdown-item text-white">รายการ</a>
                            </div>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <?php if(Auth::user()->role()->OUT == 1): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('users.edit', Auth::id())); ?> ">Profile</a>
                                <?php elseif(Auth::user()->role()->IN == 1): ?>
                                    <a class="dropdown-item"
                                        href="<?php echo e(route('salein.edit', Auth::id())); ?> ">Profile</a>
                                <?php endif; ?>
                                <?php if(Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminAgent'): ?>
                                    <a class="dropdown-item" href="<?php echo e(route('linkgis')); ?>" target="_blank">Link
                                        Register</a>
                                <?php endif; ?>
                                <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <?php echo e(__('Logout')); ?>

                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                    style="display: none;">
                                    <?php echo csrf_field(); ?>
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
                    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-lg-10 py-4 col-sm-10" id="content">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables/media/js/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/plugins/datatables/media/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/demo/table-manage-default.demo.min.js')); ?>"></script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\commission\resources\views/layouts/loged.blade.php ENDPATH**/ ?>