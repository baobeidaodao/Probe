<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: search.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 08:55:00
 */
?>

{!! Form::open(['method'=> 'POST', 'url' => 'admin/u-disk/search']) !!}
<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputUuid">Uuid</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">Uuid</div>
            </div>
            <input name="uuid" type="text" class="form-control" id="inputUuid" placeholder="uuid" @if(isset($search) && isset($search['uuid'])) value="{{ $search['uuid'] or '' }}" @endif >
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputUserName">User</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">User</div>
            </div>
            <input name="user_name" type="text" class="form-control" id="inputUserName" placeholder="user_name" @if(isset($search) && isset($search['user_name'])) value="{{ $search['user_name'] or '' }}" @endif >
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="selectOperatorId">operator_id</label>
        <div class="form-group mb-2">
            <select name="operator_id" class="form-control" id="selectOperatorId">
                <option value="">Choose...</option>
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if(isset($search) && isset($search['operator_id']) && $operator['id'] == $search['operator_id']) selected @endif >{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">Search</button>
    </div>
</div>
{!! Form::close() !!}
