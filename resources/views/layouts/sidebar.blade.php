@php
    $currentUrl = explode('/', Request::path())[0];
    $role = Auth::user()->role();
    //echo "out: ".$role->OUT." in : ".$role->IN ;
@endphp
<div class="">
    <ul class=" list-group">
        @if ($role->name != 'Team Leader')
            <li class=""><a href="{{ route('dashboard') }}"
                    class="list-group-item border-top-0 @if ($currentUrl == 'dashboard') active @endif">แดชบอร์ด</a>
            </li>
            <li class=""><a href="{{ route('news.index') }}"
                    class="list-group-item border-top-0 @if ($currentUrl == 'news') active @endif">ข่าวสาร</a>
            </li>
            <li class=""><a href="{{ route('promotions.index') }}"
                    class="list-group-item border-top-0 @if ($currentUrl == 'promotions') active @endif">โปรโมชั่น</a>
            </li>
            {{-- <li class=""><a href="{{route('projects.index')}}"
                class="list-group-item border-top-0 @if ($currentUrl == 'projects') active @endif">โครงการ</a>
        </li> --}}
            <li class=""><a href="https://vbstock.vbeyond.co.th/agent/{{ Auth::user()->id }}/{{ $role->id }}"
                    class="list-group-item border-top-0" target="_blank">โครงการ</a>
            </li>
            {{-- <li class=""><a href="http://127.0.0.1:8000/agent/{{Auth::user()->id}}/{{$role->id}}"
                class="list-group-item border-top-0" target="_blank">โครงการ</a>
        </li> --}}
        @endif
 
            <li> <a href="{{ route('lists.index') }}"
                    class="list-group-item border-top-0 @if ($currentUrl == 'lists') active @endif">รายการ</a>
            </li>
    

        {{-- TEAM OUT --}}
        @if ($role->OUT == 1)
            @include('sidebar.out')
        @endif
        {{-- END TEAM OUT --}}

        {{-- TEAM IN --}}
        @if ($role->IN == 1)
            @include('sidebar.in')
        @endif
        {{-- END TEAM IN --}}

        @if ($role->name != 'Team Leader')
            <li class="" style="background:#F7A236;text-align:center;color:#fff">คู่มือใช้งาน</li>
            <li> <a href="/ManualAgentRev1.pdf" target="_blank" role="button"
                    class="list-group-item border-top-0">คู่มือ Agent</a> </li>
        @endif

        @if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminSupport')
            <li> <a href="/ManualAdmin78.pdf" target="_blank" role="button" class="list-group-item border-top-0">คู่มือ
                    Admin</a> </li>
        @endif

        @if (Auth::user()->role()->name == 'AdminAgent')
            <li> <a href="/ManualAdminAgentRev1.pdf" target="_blank" role="button"
                    class="list-group-item border-top-0">คู่มือ AdminAgent</a> </li>
        @endif

        {{ Form::open(['route' => 'logout', Auth::id()]) }}
        {{ Form::submit('ออกจากระบบ', ['class' => 'list-group-item border-top-0 text-left w-100']) }}
        {{ Form::close() }}

    </ul>

</div>
