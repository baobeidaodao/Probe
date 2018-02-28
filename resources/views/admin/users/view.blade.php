<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: view.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 06:08:00
 */
?>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="viewInputName{{ $user->id or 0 }}">Name</label>
            <input name="name" type="text" class="form-control" id="viewInputName{{ $user->id or 0 }}" value="{{ $user->name or '' }}" placeholder="Enter Name" readonly>
        </div>
        <div class="form-group">
            <label for="viewInputEmail{{ $user->id or 0 }}">Email</label>
            <input name="email" type="email" class="form-control" id="viewInputEmail{{ $user->id or 0 }}" value="{{ $user->email or '' }}" placeholder="Enter Email" readonly>
        </div>
        <input type="hidden" name="password" value="123456">
        <div class="form-group">
            <label for="viewInputPhone{{ $user->id or 0 }}">Phone</label>
            <input name="phone" type="text" class="form-control" id="viewInputPhone{{ $user->id or 0 }}" value="{{ $user->phone or '' }}" placeholder="Enter Phone" readonly>
        </div>
        <div class="form-group">
            <label for="viewSelectLevel{{ $user->id or 0 }}">Level</label>
            <select name="level" class="form-control" id="viewSelectLevel{{ $user->id or 0 }}" readonly>
                @foreach($userLevelList as $userLevel)
                    <option value="{{ $userLevel['id'] or 0 }}" @if($userLevel['id'] == $user->level) selected @endif >{{ $userLevel['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <label for="">Area</label>
        @include('common.area', ['for' => 'view' . $user->id, 'area_id' => $user->area_id, 'readonly' => true, ])
        <div class="form-group">
            <label for="viewSelectDepartment{{ $user->id or 0 }}">Department</label>
            <select name="department_id" class="form-control" id="viewSelectDepartment{{ $user->id or 0 }}" readonly>
                @foreach($departmentList as $department)
                    <option value="{{ $department['id'] or 0 }}" @if($department['id'] == $user->department_id) selected @endif >{{ $department['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Role</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input name="role[]" class="form-check-input" type="checkbox" value="{{ $role->id or '' }}" id="viewCheckbox{{ $user->id or 0 }}{{ $loop->iteration }}" @if($user->hasRole($role->name)) checked="checked" @endIf disabled>
                    <label class="form-check-label" for="viewCheckbox{{ $user->id or 0 }}{{ $loop->iteration }}">
                        {{ $role->display_name or $role->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>
