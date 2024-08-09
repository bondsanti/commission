<?php $__env->startSection('title', 'รายการ'); ?>
<?php $__env->startSection('content'); ?>
<?php
use Illuminate\Support\Str;
?>

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <form method="post" action="<?php echo e(route('list.search')); ?>" id="searchForm">
                        <?php echo csrf_field(); ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>วันที่</label>
                                        <select id="dt" name="dt" class="form-control"
                                            data-placeholder="" style="width: 100%;">
                                            <option value="all"> ทั้งหมด</option>
                                            <option value="resultdate"> Result Date</option>
                                            <option value="senddate">Sent Date</option>
                                            <option value="receiveddate">Received Date</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>วันเริ่ม</label>
                                        <input type="text" id="calendar_input1" class="form-control datepicker"
                                            name="startdate"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>วันที่สิ้นสุด</label>
                                        <input type="text" id="calendar_input2" class="form-control datepicker"
                                            name="enddate"
                                            value="">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>โครงการ</label>
                                        <select id="project" name="project" class="form-control"
                                            data-placeholder="เลือกโครงการ" style="width: 100%;">
                                            <option value="all">ทั้งหมด</option>
                                            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ห้องเลขที่</label>
                                        <input class="form-control" name="roomno" id="roomno" type="text"
                                            value="<?php echo e(old('roomno', request()->get('roomno', ''))); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="ถึงช่วงราคา-group">
                                        <label>ชื่อลูกค้า</label>
                                        <input class="form-control" name="name" id="name" type="text"
                                            value="<?php echo e(old('name', request()->get('name', ''))); ?>">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ธนาคาร</label>
                                        <select id="bank" name="bank" class="form-control"
                                            data-placeholder="เลือกสถานะ" style="width: 100%;">
                                            <option value="all">ทั้งหมด</option>
                                            <option value="BAY">BAY</option>
                                            <option value="BBL">BBL</option>
                                            <option value="CIMB">CIMB</option>
                                            <option value="GSB">GSB</option>
                                            <option value="ISALAM">ISALAM</option>
                                            <option value="KBANK">KBANK</option>
                                            <option value="SCB">SCB</option>
                                            <option value="TBANK">TBANK</option>
                                            <option value="TMB">TMB</option>
                                            <option value="UOB">UOB</option>
                                            <option value="ธอส">ธอส</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row search-form form-group">
                                <div class="col-lg-12">
                                    <label for="" class="col-md-12 col-form-label">สถานะ</label>
                                    <div class="col-md-12 my-auto">
                                        <?php
                                            $status = [
                                                'Received',
                                                'Pending',
                                                'Waiting',
                                                'Pre-Approved',
                                                'Approved',
                                                'Rejected',
                                                'Canceled',
                                                'Returned',
                                                'Deducted',
                                                'Mortgaged',
                                                'Contract',
                                                'SLA',
                                            ];
                                        ?>
                                        <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <input type="checkbox" name="status[]" class="status" id="<?php echo e($item); ?>"
                                                value="<?php echo e($item); ?>"
                                                <?php if(isset($_GET['status'])): ?>
                                                <?php echo e(in_array($item, $_GET['status']) ? 'checked' : ''); ?>

                                            <?php else: ?>
                                                checked
                                            <?php endif; ?>>
                                            <label for="<?php echo e($item); ?>"><?php echo e($item); ?></label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <a href="javascript:;" id="toggle_check1" class="btn btn-light btn-xs">Uncheck
                                            all</a>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row form-group">
                            <div class="col-lg-12">
                                <div class="box-footer text-center">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="<?php echo e(route('lists.index')); ?>" type="button" class="btn btn-danger"><i
                                            class="fa fa-refresh"></i>
                                        เคลียร์</a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>


        


    </div><!-- /.container-fluid -->



<?php $__env->stopSection(); ?>

<!-- Check&UnCheck ALL-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.getElementById('toggle_check1');
        var checkboxes = document.querySelectorAll('.status');

        var updateToggleButton = function() {
            var isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            toggleButton.textContent = isChecked ? 'Uncheck all' : 'Check all';
        };

        updateToggleButton();

        toggleButton.addEventListener('click', function() {
            var shouldCheck = toggleButton.textContent === 'Check all';
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = shouldCheck;
            });
            updateToggleButton();
        });
    });
</script>


<?php echo $__env->make('layouts.loged', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\commission\resources\views/pages/lists/index.blade.php ENDPATH**/ ?>