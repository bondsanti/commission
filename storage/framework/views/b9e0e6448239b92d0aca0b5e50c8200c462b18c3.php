<?php if($role->name == 'Admin'|| $role->name == 'Account' || $role->name == 'AdminAgent' || $role->name == 'AdminSupport'): ?>
<li class="" style="background:#F7A236;text-align:center;color:#fff">Sale Out</li>

<?php endif; ?>
<?php if(!$role->name == 'Team Leader'): ?>
<li class=""><a href="<?php echo e(route('calendars.index')); ?>"
                class="list-group-item border-top-0 <?php if($currentUrl == 'calendars'): ?> active <?php endif; ?>">ปฏิทิน</a>
</li>
<?php endif; ?>
<?php if( $role->name != 'Account' && $role->name != 'Team Leader'): ?>
<li class=""> <a href="<?php echo e(route('users.index')); ?>"
                class="list-group-item border-top-0 <?php if($currentUrl == 'users'): ?> active <?php endif; ?>">Agents</a> </li>
<?php endif; ?>



<?php if($role->name == 'Admin' || $role->name == 'AdminAgent' || $role->name == 'AdminSupport'): ?>
<li class="">
    <a href="<?php echo e(route('regis.list')); ?>" class="list-group-item border-top-0 <?php if($currentUrl == 'member'): ?> active <?php endif; ?>">รายชื่อสมัคร Agent</a> 
</li>


<li> <a href="<?php echo e(route('commissions.index')); ?>"
                class="list-group-item border-top-0 <?php if($currentUrl == 'commissions'): ?> active <?php endif; ?>">คอมมิชชั่น</a>
</li>

<li> <a href="<?php echo e(route('roles.index')); ?>"
                class="list-group-item border-top-0 <?php if($currentUrl == 'roles'): ?> active <?php endif; ?>">ตำแหน่ง</a>
</li>
<li> <a href="<?php echo e(route('teams.index')); ?>"
                class="list-group-item border-top-0 <?php if($currentUrl == 'teams'): ?> active <?php endif; ?>">ทีม</a>
</li>
<?php endif; ?>





<?php /**PATH C:\xampp\htdocs\commission\resources\views/sidebar/out.blade.php ENDPATH**/ ?>