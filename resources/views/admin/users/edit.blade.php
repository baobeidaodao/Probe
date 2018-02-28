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
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="editInputName{{ $user->id or 0 }}">Name</label>
            <input name="name" type="text" class="form-control" id="editInputName{{ $user->id or 0 }}" value="{{ $user->name or '' }}" placeholder="Enter Name" @if($user->name === 'admin') readonly @endif>
        </div>
        <div class="form-group">
            <label for="editInputEmail{{ $user->id or 0 }}">Email</label>
            <input name="email" type="email" class="form-control" id="editInputEmail{{ $user->id or 0 }}" value="{{ $user->email or '' }}" placeholder="Enter Email">
        </div>
        <div class="form-group">
            <label for="editInputPassword{{ $user->id or 0 }}">Password</label>
            <input name="password" type="password" class="form-control" id="editInputPassword{{ $user->id or 0 }}" value="" placeholder="Enter Password">
        </div>
        <div class="form-group">
            <label for="editInputPhone{{ $user->id or 0 }}">Phone</label>
            <input name="phone" type="text" class="form-control" id="editInputPhone{{ $user->id or 0 }}" value="{{ $user->phone or '' }}" placeholder="Enter Phone">
        </div>
        <div class="form-group">
            <label for="editSelectLevel{{ $user->id or 0 }}">Level</label>
            <select name="level" class="form-control" id="editSelectLevel{{ $user->id or 0 }}">
                <option selected>Choose...</option>
                @foreach($userLevelList as $userLevel)
                    <option value="{{ $userLevel['id'] or 0 }}" @if($userLevel['id'] == $user->level) selected @endif >{{ $userLevel['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <label for="">Area</label>
        @include('common.area', ['for' => 'edit' . $user->id, 'area_id' => $user->area_id, ])
        <div class="form-group">
            <label for="editSelectDepartment{{ $user->id or 0 }}">Department</label>
            <select name="department_id" class="form-control" id="editSelectDepartment{{ $user->id or 0 }}">
                <option selected>Choose...</option>
                @foreach($departmentList as $department)
                    <option value="{{ $department['id'] or 0 }}" @if($department['id'] == $user->department_id) selected @endif >{{ $department['name'] or '' }}</option>
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
