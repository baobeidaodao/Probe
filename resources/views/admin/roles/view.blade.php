<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: view.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 06:26:00
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
            <label for="viewInputName{{ $role->id or 0 }}">名称</label>
            <input name="name" type="text" class="form-control" id="viewInputName{{ $role->id or 0 }}" value="{{ $role->name or '' }}" placeholder="名称" readonly >
        </div>
        <div class="form-group">
            <label for="viewInputDisplayName{{ $role->id or 0 }}">显示名称</label>
            <input name="display_name" type="text" class="form-control" id="viewInputDisplayName{{ $role->id or 0 }}" value="{{ $role->display_name or '' }}" placeholder="显示名称" readonly >
        </div>
        <div class="form-group">
            <label for="viewInputDescription{{ $role->id or 0 }}">描述</label>
            <textarea name="description" class="form-control" id="viewInputDescription{{ $role->id or 0 }}" placeholder="描述" readonly >{{ $role->description or '' }}</textarea>
        </div>
        <div class="form-group">
            <label>权限</label>
            @foreach($perms as $perm)
                <div class="form-check">
                    <input name="perm[]" class="form-check-input" type="checkbox" value="{{ $perm->id }}" id="viewCheckbox{{ $role->id or 0 }}{{ $perm->id or 0 }}" @if($role->hasPermission($perm->name)) checked="checked" @endIf disabled >
                    <label class="form-check-label" for="viewCheckbox{{ $role->id or 0 }}{{ $perm->id or 0 }}">
                        {{ $perm->display_name or $perm->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
    </div>
</div>

