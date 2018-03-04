<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: create_form.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-08 05:49:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'POST', 'route'=> 'roles.store']) !!}
    <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="createInputName">名称</label>
            <input name="name" type="text" class="form-control" id="createInputName" placeholder="名称">
        </div>
        <div class="form-group">
            <label for="createInputDisplayName">显示名称</label>
            <input name="display_name" type="text" class="form-control" id="createInputDisplayName" placeholder="显示名称">
        </div>
        <div class="form-group">
            <label for="createInputDescription">描述</label>
            <textarea name="description" class="form-control" id="createInputDescription" placeholder="描述"></textarea>
        </div>
        <div class="form-group">
            <label>权限</label>
            @foreach($perms as $perm)
                <div class="form-check">
                    <input name="perm[]" class="form-check-input" type="checkbox" value="{{ $perm->id or '' }}" id="createCheckbox{{ $perm->id or 0 }}">
                    <label class="form-check-label" for="createCheckbox{{ $perm->id or 0 }}">
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
