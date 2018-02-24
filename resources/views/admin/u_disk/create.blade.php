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
    {!! Form::open(['method'=> 'POST', 'route' => 'u-disk.store']) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputUuid">uuid</label>
            <input name="uuid" type="text" class="form-control" id="inputUuid" placeholder="Enter Uuid">
        </div>
        <div class="form-group">
            <label for="selectUserId">User</label>
            <select name="user_id" class="form-control" id="selectUserId">
                <option selected>Choose...</option>
                @foreach($userList as $user)
                    <option value="{{ $user['id'] or 0 }}">{{ $user['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectOperatorId">Operator</label>
            <select name="operator_id" class="form-control" id="selectOperatorId">
                <option selected>Choose...</option>
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}">{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
    {!! Form::close() !!}
</div>
