@if ($role->name == 'Admin'|| $role->name == 'Account')
<li class="" style="background:#F7A236;text-align:center;color:#fff">Sale Out</li>
@endif
<li class=""><a href="{{route('calendars.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'calendars') active @endif">ปฏิทิน</a>
</li>

@if ( $role->name != 'Account')
<li class=""> <a href="{{route('users.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'users') active @endif">Agents</a> </li>
@endif
@if(

$role->name != 'Support'
)

@endif
<li> <a href="{{route('lists.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'lists') active @endif">รายการ</a>
</li>
<li> <a href="{{route('commissions.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'commissions') active @endif">คอมมิชชั่น</a>
</li>
@if(
$role->name == 'Admin'
)
        <li class=""><a href="{{route('projects.index')}}"
                class="list-group-item border-top-0 @if($currentUrl == 'projects') active @endif">โครงการ</a>
        </li>
<li> <a href="{{route('roles.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'roles') active @endif">ตำแหน่ง</a> </li>
<li> <a href="{{route('teams.index')}}"
        class="list-group-item border-top-0 @if($currentUrl == 'teams') active @endif">ทีม</a> </li>
{{-- <li > <a href="{{route('settings.index')}}" class="list-group-item border-top-0 @if($currentUrl ==
'settings') active @endif">Setting</a> </li> --}}
{{-- <li > <a href="{{route('subteams.index')}}" class="list-group-item border-top-0">Sub Teams</a> </li> --}}
@endif

{{-- <li class="" style="background:#F7A236">   </li> --}}
