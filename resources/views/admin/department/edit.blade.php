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
    {!! Form::open(['method' => 'patch', 'route' => ['department.update', $department['id'], ], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputName">名称</label>
            <input name="name" type="text" class="form-control" id="inputName" value="{{ $department['name'] or '' }}" placeholder="名称">
        </div>
        <label for="">地区</label>
        @include('common.area', ['for' => 'edit' . $department['id'], 'area_id' => $department['area_id'], ])
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
