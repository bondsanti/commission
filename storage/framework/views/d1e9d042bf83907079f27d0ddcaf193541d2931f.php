<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('css'); ?>
<link href="/assets/plugins/nvd3/nvd3.min.css" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        
        <?php if(Auth::user()->role()->name != 'Authorizer' &&
        Auth::user()->role()->name != 'Account'): ?>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">รวมค่าคอมมิชชั่น รายเดือน</div>
                <div class="card-body">
                    <div id="nv-bar-chart" class="height-sm"></div>
                </div>
            </div>
        </div>
        <?php if(Auth::user()->role()->name != 'Authorizer' &&
        Auth::user()->role()->name != 'Account' &&
        Auth::user()->role()->name != 'Admin'): ?>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">ข่าวสาร</div>
                <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <a href="<?php echo e(route('news.show', $item->id)); ?>" class="card-link">

                    <div class="card cursor-pointer">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-2">
                                    <?php if($item->image): ?>
                                    <img src="<?php echo e($item->image); ?>" alt="">
                                    <?php else: ?>
                                    <img src="/images/favicon.png" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-10">
                                    <div class="col-md-12">
                                        <h4><?php echo e($item->title); ?></h4>
                                        <hr>
                                    </div>
                                    <div class="col-md-12" style="font-weight: 300;">
                                        <?php echo e(substr( $item->content, 0,200).'...'); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <?php if(Auth::user()->role()->name == 'Admin'): ?>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">รวมตำแหน่ง</div>
                <div class="card-body">
                    <div id="nv-donut-chart" class="height-sm"></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php if( count($roleLog) > 0 ): ?>
    <?php if(Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'Authorizer' ): ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">การเปลี่ยนแปลงตำแหน่ง</div>

                <div class="card-body">
                    <?php echo $__env->make('pages.dashboards.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php if( count($roleLogReject) > 0 ): ?>
    <?php if(Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'Authorizer' &&
    count($roleLogReject) > 0): ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">คนที่โดนปฏิเสธ</div>
                <div class="card-body">
                    <?php echo $__env->make('pages.dashboards.reject', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="/assets/plugins/d3/d3.min.js"></script>
<script src="/assets/plugins/nvd3/nv.d3.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    let stream1 = {};
		$(document).ready(function() {
			ChartNvd3.init();

            axios.get('/api/stat/stackedBarChart')
            .then(function (response) {
                stackedBarChartData = response.data
                handleStackedBarChart();

            })
            .catch(function (error) {
                console.log(error);
            });

            axios.get('/api/stat/handleBarChart?user=<?php echo e(Auth::id()); ?>',
            {
                 user:<?php echo e(Auth::id()); ?>

            })
            .then(function (response) {
                barChartData = response.data
                handleBarChart();

            })
            .catch(function (error) {
                console.log(error);
            });

            axios.get('/api/stat/handlePieAndDonutChart',{
                user:<?php echo e(Auth::id()); ?>

            })
            .then(function (response) {
                pieChartData = response.data
                handlePieAndDonutChart();

            })
            .catch(function (error) {
                console.log(error);
            });

            // pieChartData

		});
</script>

<script>
    var ChartNvd3 = function () {
    "use strict";
    return {
        //main function
        init: function () {
            // handlePieAndDonutChart()
            // handleBarChart();
        }
    };
}();


var handleStackedBarChart = function () {
    "use strict";

    nv.addGraph({
        generate: function () {
            var stackedBarChart = nv.models.multiBarChart()
                .stacked(true)
                .showControls(false);

            var svg = d3.select('#nv-stacked-bar-chart').append('svg').datum(stackedBarChartData);
            svg.transition().duration(0).call(stackedBarChart);
            return stackedBarChart;
        }
    });
};

var handleBarChart = function () {
    "use strict";
    nv.addGraph(function () {
        var barChart = nv.models.discreteBarChart()
            .x(function (d) { return d.label })
            .y(function (d) { return d.value })
            .showValues(true)
            .duration(250);

        barChart.yAxis.axisLabel("Total Commission");
        barChart.xAxis.axisLabel('Months');

        d3.select('#nv-bar-chart').append('svg').datum(barChartData).call(barChart);
        nv.utils.windowResize(barChart.update);

        return barChart;
    });
}


var handlePieAndDonutChart = function () {
    "use strict";

    nv.addGraph(function () {
        var pieChart = nv.models.pieChart()
            .x(function (d) { return d.label })
            .y(function (d) { return d.value })
            .showLabels(true)
            .labelThreshold(.05);

        d3.select('#nv-pie-chart').append('svg')
            .datum(pieChartData)
            .transition().duration(350)
            .call(pieChart);

        return pieChart;
    });


    nv.addGraph(function () {
        var chart = nv.models.pieChart()
            .x(function (d) { return d.label })
            .y(function (d) { return d.value })
            .showLabels(true)
            .labelThreshold(.05)
            .labelType("percent")
            .donut(true)
            .donutRatio(0.35);

        d3.select('#nv-donut-chart').append('svg')
            .datum(pieChartData)
            .transition().duration(350)
            .call(chart);

        return chart;
    });
};


// nv-donut-chart
</script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.loged', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\commission\resources\views/pages/dashboard.blade.php ENDPATH**/ ?>