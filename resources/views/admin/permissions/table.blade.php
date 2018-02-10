<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: role_card.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-08 05:44:00
 */
?>

<table class="table table-striped">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">名称</th>
        <th scope="col">显示名称</th>
        <th scope="col">描述</th>
    </tr>
    </thead>
    <tbody>
    @foreach($perms as $perm)
        <tr>
            <th scope="row">{{ $perm->id or 0 }}</th>
            <td>{{ $perm->name or '' }}</td>
            <td>{{ $perm->display_name or '' }}</td>
            <td>{{ $perm->description or '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
