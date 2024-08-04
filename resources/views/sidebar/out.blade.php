@if ($role->name == 'Admin'|| $role->name == 'Account' || $role->name == 'AdminAgent' || $role->name == 'AdminSupport')
<li class="" style="background:#F7A236;text-align:center;color:#fff">Sale Out</li>

@endif
@if(!$role->name == 'Team Leader')
<li class=""><a href="{{route('calendars.index')}}"
                class="list-group-item border-top-0 @if($currentUrl == 'calendars') active @endif">ปฏิทิน</a>
</li>
@endif
@if ( $role->name != 'Account' && $role->name != 'Team Leader')
<li class=""> <a href="{{route('users.index')}}"
                class="list-group-item border-top-0 @if($currentUrl == 'users') active @endif">Agents</a> </li>
@endif



@if($role->name == 'Admin' || $role->name == 'AdminAgent' || $role->name == 'AdminSupport')
<li class="">
    <a href="{{route('regis.list')}}" class="list-group-item border-top-0 @if($currentUrl == 'member') active @endif">รายชื่อสมัคร Agent</a> 
</li>

{{-- <li> <a href="{{route('lists.index')}}"
                class="list-group-item border-top-0 @if($currentUrl == 'lists') active @endif">รายการ</a>
</li> --}}
<li> <a href="{{route('commissions.index')}}"
                class="list-group-item border-top-0 @if($currentUrl == 'commissions') active @endif">คอมมิชชั่น</a>
</li>

<li> <a href="{{route('roles.index')}}"
                class="list-group-item border-top-0 @if($currentUrl == 'roles') active @endif">ตำแหน่ง</a>
</li>
<li> <a href="{{route('teams.index')}}"
                class="list-group-item border-top-0 @if($currentUrl == 'teams') active @endif">ทีม</a>
</li>
@endif





