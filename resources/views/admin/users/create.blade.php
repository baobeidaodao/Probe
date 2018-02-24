<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: create.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 00:04:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'POST', 'route'=> 'users.store']) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputName">Name</label>
            <input name="name" type="text" class="form-control" id="inputName" placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Enter Email">
        </div>
        <input type="hidden" name="password" value="123456">
        <div class="form-group">
            <label for="inputPhone">Phone</label>
            <input name="phone" type="text" class="form-control" id="inputPhone" placeholder="Enter Phone">
        </div>
        <div class="form-group">
            <label for="selectLevel">Level</label>
            <select name="level" class="form-control" id="selectLevel">
                <option selected>Choose...</option>
                @foreach($userLevelList as $userLevel)
                    <option value="{{ $userLevel['id'] or 0 }}">{{ $userLevel['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <label for="">Area</label>
        @include('common.area', ['area_id' => '', ])
        <div class="form-group">
            <label>Role</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input name="role[]" class="form-check-input" type="checkbox" value="{{ $role->id or '' }}" id="checkbox{{ $loop->iteration }}">
                    <label class="form-check-label" for="checkbox{{ $loop->iteration }}">
                        {{ $role->display_name or $role->name }}
                    </label>
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
