@if ($role->name == 'Admin'|| $role->name == 'Account')
<li class="" style="background:#F7A236;text-align:center;color:#fff">Sale IN</li>
@endif

@if ( $role->name != 'Account')
<li class=""> <a href="{{route('salein.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'salein') active @endif">Sales</a>
</li>
<li> <a href="{{route('lists.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'lists') active @endif">รายการ</a>
</li>
@endif

<li> <a href="{{route('commissionssalein.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'commissionssalein') active @endif">คอมมิชชั่น</a>
</li>

@if ($role->name == 'Admin'|| $role->name == 'Account')
<li ><a href="{{route('commissionssalein.setting')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'setting') active @endif">ตั้งค่าคอมมิชชั่น </a></li>
@endif


{{-- <li class="" style="background:#F7A236">   </li> --}}
