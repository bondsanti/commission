<?php if($role->name == 'Admin'|| $role->name == 'Account'): ?>
<li class="" style="background:#F7A236;text-align:center;color:#fff">Sale IN</li>
<?php endif; ?>

<?php if( $role->name != 'Account'): ?>
<li class=""> <a href="<?php echo e(route('salein.index')); ?>"
        class="list-group-item border-top-0 <?php if($currentUrl == 'salein'): ?> active <?php endif; ?>">Sales</a>
</li>
<li> <a href="<?php echo e(route('lists.index')); ?>"
        class="list-group-item border-top-0 <?php if($currentUrl == 'lists'): ?> active <?php endif; ?>">รายการ</a>
</li>
<?php endif; ?>

<li> <a href="<?php echo e(route('commissionssalein.index')); ?>"
        class="list-group-item border-top-0 <?php if($currentUrl == 'commissionssalein'): ?> active <?php endif; ?>">คอมมิชชั่น</a>
</li>

<?php if($role->name == 'Admin'|| $role->name == 'Account'): ?>
<li ><a href="<?php echo e(route('commissionssalein.setting')); ?>"
        class="list-group-item border-top-0 <?php if($currentUrl == 'setting'): ?> active <?php endif; ?>">ตั้งค่าคอมมิชชั่น </a></li>
<?php endif; ?>



<?php /**PATH C:\xampp\htdocs\commission\resources\views/sidebar/in.blade.php ENDPATH**/ ?>