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
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        @if($role->name !== 'admin')
            <div class="form-group">
                <label for="editInputName{{ $role->id or 0 }}">名称</label>
                <input name="name" type="text" class="form-control" id="editInputName{{ $role->id or 0 }}" value="{{ $role->name or '' }}" placeholder="名称">
            </div>
        @else
            <input name="name" type="hidden" class="form-control" id="editInputName{{ $role->id or 0 }}" value="{{ $role->name or '' }}" placeholder="名称">
        @endif
        <div class="form-group">
            <label for="editInputDisplayName{{ $role->id or 0 }}">显示名称</label>
            <input name="display_name" type="text" class="form-control" id="editInputDisplayName{{ $role->id or 0 }}" value="{{ $role->display_name or '' }}" placeholder="显示名称">
        </div>
        <div class="form-group">
            <label for="editInputDescription{{ $role->id or 0 }}">描述</label>
            <textarea name="description" class="form-control" id="editInputDescription{{ $role->id or 0 }}" placeholder="描述">{{ $role->description or '' }}</textarea>
        </div>
        <div class="form-group">
            <label>权限</label>
            @foreach($perms as $perm)
                <div class="form-check">
                    <input name="perm[]" class="form-check-input" type="checkbox" value="{{ $perm->id }}" id="editCheckbox{{ $role->id or 0 }}{{ $perm->id or 0 }}" @if($role->hasPermission($perm->name)) checked="checked" @endIf >
                    <label class="form-check-label" for="editCheckbox{{ $role->id or 0 }}{{ $perm->id or 0 }}">
                        {{ $perm->display_name or $perm->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
