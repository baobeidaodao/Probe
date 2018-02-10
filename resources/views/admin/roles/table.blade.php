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
        <th scope="col">操作</th>
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewRole{{ $loop->iteration }}">
                    View
                </button>
                <div class="modal fade" id="viewRole{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        @include('admin.roles.view')
                    </div>
                </div>
                @ability('admin', 'edit_role', ['validate_all' => false,])
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRole{{ $loop->iteration }}">
                    Edit
                </button>
                <div class="modal fade" id="editRole{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        @include('admin.roles.edit')
                    </div>
                </div>
                @endability
                @if($role->name !== 'admin')
                    @permission('delete_role')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteRole{{ $loop->iteration }}">
                        Delete
                    </button>
                    <div class="modal fade" id="deleteRole{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                @include('admin.roles.delete')
                            </div>
                        </div>
                    </div>
                    @endpermission
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
