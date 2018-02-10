<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: edit.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 00:15:00
 */
?>

{!! Form::open(['method' => 'patch', 'route' => ['users.update', $user->id], ]) !!}
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if($user->name !== 'admin')
            <div class="form-group">
                <label for="inputName">Name</label>
                <input name="name" type="text" class="form-control" id="inputName" value="{{ $user->name or '' }}" placeholder="Enter Name">
            </div>
        @endif
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input name="email" type="email" class="form-control" id="inputEmail" value="{{ $user->email or '' }}" placeholder="Email">
        </div>
        <div class="form-group">
            <label for="checkboxDescription">角色</label>
            @foreach($roles as $role)
                {!! Form::checkbox('role[]', $role->id, $user->hasRole($role->name) ? true:false) !!}
                {{ $role->display_name or $role->name }}
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</div>
{!! Form::close() !!}
