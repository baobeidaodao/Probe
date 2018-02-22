<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: edit.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 00:15:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'patch', 'route' => ['users.update', $user->id], ]) !!}
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
            <label for="inputPhone">Phone</label>
            <input name="phone" type="text" class="form-control" id="inputPhone" placeholder="Enter Phone">
        </div>
        <div class="form-group">
            <label for="selectLevel">Level</label>
            <select name="level" class="form-control" id="selectLevel">
                <option selected>Choose...</option>
                @foreach($userLevelList as $userLevel)
                    <option value="{{ $userLevel['id'] or 0 }}" @if($userLevel['id'] == $user->level) selected @endif >{{ $userLevel['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>角色</label>
            @foreach($roles as $role)
                <div class="form-check">
                    {!! Form::checkbox('role[]', $role->id, $user->hasRole($role->name) ? true:false) !!}
                    {{ $role->display_name or $role->name }}
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
    {!! Form::close() !!}
</div>
