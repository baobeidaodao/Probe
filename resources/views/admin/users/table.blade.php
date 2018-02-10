<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: table.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 00:06:00
 */
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <th scope="row">{{ $user->id or 0 }}</th>
            <td>{{ $user->name or '' }}</td>
            <td>{{ $user->email or '' }}</td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#viewUser{{ $user->id or 0 }}">
                    View
                </button>
                <div class="modal fade" id="viewUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        @include('admin.users.view')
                    </div>
                </div>
                @ability('admin', 'edit_user', ['validate_all' => false,])
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUser{{ $user->id or 0 }}">
                    Edit
                </button>
                <div class="modal fade" id="editUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        @include('admin.users.edit')
                    </div>
                </div>
                @endability
                @if($user->name !== 'admin')
                    @permission('delete_user')
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteUser{{ $user->id or 0 }}">
                        Delete
                    </button>
                    <div class="modal fade" id="deleteUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                @include('admin.users.delete')
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
