<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: edit.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 14:04:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'patch', 'route' => ['permissions.update', $perm->id], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputName">名称</label>
            <input name="name" type="text" class="form-control" id="inputName" value="{{ $perm->name or '' }}" placeholder="名称">
        </div>
        <div class="form-group">
            <label for="inputDisplayName">显示名称</label>
            <input name="display_name" type="text" class="form-control" id="inputDisplayName" value="{{ $perm->display_name or '' }}" placeholder="显示名称">
        </div>
        <div class="form-group">
            <label for="inputDescription">描述</label>
            <textarea name="description" class="form-control" id="inputDescription" placeholder="描述">{{ $perm->description or '' }}</textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
