<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: create_form.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-08 05:49:00
 */
?>

<form method="post" action="{{ route('permissions.store') }}">
    {{ csrf_field() }}
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
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
