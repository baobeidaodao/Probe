<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: delete.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 00:15:00
 */
?>

{!! Form::open(['method' => 'delete', 'route' => ['users.destroy', $user->id], ]) !!}
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    确认删除用户：{{ $user->name or $user->email }} ？
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Delete</button>
</div>
{!! Form::close() !!}
