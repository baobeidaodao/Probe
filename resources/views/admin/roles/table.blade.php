<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: role_card.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-08 05:44:00
 */
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">名称</th>
        <th scope="col">显示名称</th>
        <th scope="col">描述</th>
        <th scope="col">权限</th>
    </tr>
    </thead>
    <tbody>
    @foreach($roles as $role)
        <tr>
            <th scope="row">{{ $role->id or 0 }}</th>
            <td>{{ $role->name or '' }}</td>
            <td>{{ $role->display_name or '' }}</td>
            <td>{{ $role->description or '' }}</td>
            <td>
                <ul>
                    @foreach($role->perms as $perm)
                        <li>{{ $perm->display_name or $perm->name }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
