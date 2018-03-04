<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: delete.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 14:00:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'delete', 'route' => ['department.destroy', $department['id'], ], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        确认删除部门：{{ $department['name'] or '' }} ？
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">删除</button>
    </div>
    {!! Form::close() !!}
</div>
