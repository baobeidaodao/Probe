<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: create_form.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-08 05:49:00
 */
?>

{!! Form::open(['method'=> 'POST', 'route' => 'permissions.store']) !!}
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label for="inputName">名称</label>
        <input name="name" type="text" class="form-control" id="inputName" placeholder="Enter Name">
    </div>
    <div class="form-group">
        <label for="inputDisplayName">显示名称</label>
        <input name="display_name" type="text" class="form-control" id="inputDisplayName" placeholder="Display Name">
    </div>
    <div class="form-group">
        <label for="inputDescription">描述</label>
        <textarea name="description" class="form-control" id="inputDescription" placeholder="Description"></textarea>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Save changes</button>
</div>
{!! Form::close() !!}
