<?php
    $currentUrl = explode('/', Request::path())[0];
    $role = Auth::user()->role();
    //echo "out: ".$role->OUT." in : ".$role->IN ;
?>
<div class="">
    <ul class=" list-group">
        <?php if($role->name != 'Team Leader'): ?>
            <li class=""><a href="<?php echo e(route('dashboard')); ?>"
                    class="list-group-item border-top-0 <?php if($currentUrl == 'dashboard'): ?> active <?php endif; ?>">แดชบอร์ด</a>
            </li>
            <li class=""><a href="<?php echo e(route('news.index')); ?>"
                    class="list-group-item border-top-0 <?php if($currentUrl == 'news'): ?> active <?php endif; ?>">ข่าวสาร</a>
            </li>
            <li class=""><a href="<?php echo e(route('promotions.index')); ?>"
                    class="list-group-item border-top-0 <?php if($currentUrl == 'promotions'): ?> active <?php endif; ?>">โปรโมชั่น</a>
            </li>
            
            <li class=""><a href="https://vbstock.vbeyond.co.th/agent/<?php echo e(Auth::user()->id); ?>/<?php echo e($role->id); ?>"
                    class="list-group-item border-top-0" target="_blank">โครงการ</a>
            </li>
            
        <?php endif; ?>
 
            <li> <a href="<?php echo e(route('lists.index')); ?>"
                    class="list-group-item border-top-0 <?php if($currentUrl == 'lists'): ?> active <?php endif; ?>">รายการ</a>
            </li>
    

        
        <?php if($role->OUT == 1): ?>
            <?php echo $__env->make('sidebar.out', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        

        
        <?php if($role->IN == 1): ?>
            <?php echo $__env->make('sidebar.in', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        

        <?php if($role->name != 'Team Leader'): ?>
            <li class="" style="background:#F7A236;text-align:center;color:#fff">คู่มือใช้งาน</li>
            <li> <a href="/ManualAgentRev1.pdf" target="_blank" role="button"
                    class="list-group-item border-top-0">คู่มือ Agent</a> </li>
        <?php endif; ?>

        <?php if(Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminSupport'): ?>
            <li> <a href="/ManualAdmin78.pdf" target="_blank" role="button" class="list-group-item border-top-0">คู่มือ
                    Admin</a> </li>
        <?php endif; ?>

        <?php if(Auth::user()->role()->name == 'AdminAgent'): ?>
            <li> <a href="/ManualAdminAgentRev1.pdf" target="_blank" role="button"
                    class="list-group-item border-top-0">คู่มือ AdminAgent</a> </li>
        <?php endif; ?>

        <?php echo e(Form::open(['route' => 'logout', Auth::id()])); ?>

        <?php echo e(Form::submit('ออกจากระบบ', ['class' => 'list-group-item border-top-0 text-left w-100'])); ?>

        <?php echo e(Form::close()); ?>


    </ul>

</div>
<?php /**PATH C:\xampp\htdocs\commission\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>