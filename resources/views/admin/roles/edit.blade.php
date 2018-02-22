<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: edit.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-10 15:44:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'patch', 'route' => ['roles.update', $role->id], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if($role->name !== 'admin')
            <div class="form-group">
                <label for="inputName">名称</label>
                <input name="name" type="text" class="form-control" id="inputName" value="{{ $role->name or '' }}" placeholder="Enter Name">
            </div>
        @endif
        <div class="form-group">
            <label for="inputDisplayName">显示名称</label>
            <input name="display_name" type="text" class="form-control" id="inputDisplayName" value="{{ $role->display_name or '' }}" placeholder="Display Name">
        </div>
        <div class="form-group">
            <label for="inputDescription">描述</label>
            <textarea name="description" class="form-control" id="inputDescription" placeholder="Description">{{ $role->description or '' }}</textarea>
        </div>
        <div class="form-group">
            <label>权限</label>
            @foreach($perms as $perm)
                <div class="form-check">
                    <input name="perm[]" class="form-check-input" type="checkbox" value="{{ $perm->id }}" id="checkbox{{ $loop->iteration }}" @if($role->hasPermission($perm->name)) checked="checked" @endIf >
                    <label class="form-check-label" for="checkbox{{ $loop->iteration }}">
                        {{ $perm->display_name or $perm->name }}
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
