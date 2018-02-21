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
        <a href="{{ url('admin') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'admin') active @endif ">Admin</a>
        <a href="{{ url('admin/roles') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'roles') active @endif ">角色管理</a>
        <a href="{{ url('admin/permissions') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'permissions') active @endif ">权限管理</a>
        <a href="{{ url('admin/users') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'users') active @endif ">用户管理</a>
        <a href="{{ url('admin/logs') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'logs') active @endif ">日志管理</a>
        <a href="{{ url('admin/u-disk') }}" class="list-group-item list-group-item-action list-group-item-dark text-center @if(isset($active) && $active === 'u-disk') active @endif ">U盾管理</a>
    </div>
</nav>
