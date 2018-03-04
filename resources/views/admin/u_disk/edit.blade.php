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
    {!! Form::open(['method' => 'patch', 'route' => ['u-disk.update', $uDisk['id'], ], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputUuid">uuid</label>
            <input name="uuid" type="text" class="form-control" id="inputUuid" value="{{ $uDisk['uuid'] or '' }}" placeholder="UUID">
        </div>
        <div class="form-group">
            <label for="selectUserId">人员</label>
            <select name="user_id" class="form-control" id="selectUserId">
                @foreach($userList as $user)
                    <option value="{{ $user['id'] or 0 }}" @if($user['id'] == $uDisk['user_id']) selected @endif >{{ $user['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectOperatorId">operator_id</label>
            <select name="operator_id" class="form-control" id="selectOperatorId">
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if($operator['id'] == $uDisk['operator_id']) selected @endif >{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
