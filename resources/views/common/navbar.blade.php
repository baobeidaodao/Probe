<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: navbar.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 15:47:00
 */
?>

<nav class="col-md-2 d-none d-md-block sidebar">
    @role('admin')
    @endrole
    <div class="container-fluid list-group-flush">
        @role('admin')
        <a href="{{ url('admin') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'admin') active @endif ">Admin</a>
        @endrole
        @role('admin')
        <a href="{{ url('admin/roles') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'roles') active @endif ">角色管理</a>
        @endrole
        @role('admin')
        <a href="{{ url('admin/permissions') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'permissions') active @endif ">权限管理</a>
        @endrole
        @permission('view_user')
        <a href="{{ url('admin/users') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'users') active @endif ">用户管理</a>
        @endpermission
        @permission('view_department')
        <a href="{{ url('admin/department') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'department') active @endif ">部门管理</a>
        @endpermission
        @permission('view_log')
        <a href="{{ url('admin/logs') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'logs') active @endif ">日志管理</a>
        @endpermission
        @permission('view_u_disk')
        <a href="{{ url('admin/u-disk') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'u-disk') active @endif ">U 盾管理</a>
        @endpermission
        @permission('view_ip')
        <a href="{{ url('admin/ip') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'ip') active @endif ">IP 管理</a>
        @endpermission
        @permission('view_statistics')
        @if(isset(Auth::user()->level) && Auth::user()->level <= \App\Models\UserLevel::LEVEL_GROUP_MANAGER)
            <a href="{{ url('admin/statistics/group') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'statistics') active @endif ">统计信息</a>
        @elseif(isset(Auth::user()->level) && Auth::user()->level == \App\Models\UserLevel::LEVEL_PROVINCIAL_MANAGER)
            <a href="{{ url('admin/statistics/province') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'statistics') active @endif ">统计信息</a>
        @elseif(isset(Auth::user()->level) && Auth::user()->level == \App\Models\UserLevel::LEVEL_MUNICIPAL_MANAGER)
            <a href="{{ url('admin/statistics/city') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'statistics') active @endif ">统计信息</a>
        @else
            <a href="{{ url('admin/statistics') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'statistics') active @endif ">统计信息</a>
        @endif
        @endpermission
        @permission('view_report')
        <a href="{{ url('admin/report') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'report') active @endif ">数据查询</a>
        @endpermission
    </div>
</nav>
