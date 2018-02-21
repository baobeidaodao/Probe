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
    {!! Form::open(['method' => 'delete', 'route' => ['permissions.destroy', $perm->id], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        确认删除权限：{{ $perm->display_name or $perm->name }} ？
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Delete</button>
    </div>
    {!! Form::close() !!}
</div>
