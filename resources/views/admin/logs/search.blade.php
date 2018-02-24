<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: search.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 14:53:00
 */

?>

{!! Form::open(['method'=> 'POST', 'url' => 'admin/logs/search']) !!}
<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputUser">User</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">User</div>
            </div>
            <input name="user_name" type="text" class="form-control" id="inputUser" placeholder="user" @if(isset($search) && isset($search['user_name'])) value="{{ $search['user_name'] or '' }}" @endif >
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputStartDate">StartDate</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">StartDate</div>
            </div>
            @include('common.date_picker', ['id' => 'inputStartDate', 'name' => 'start_date', 'value' => (isset($search) && isset($search["start_date"])) ? $search["start_date"] : '', 'format' => 'yyyy-mm-dd hh:ii:ss', ])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">EndDate</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">EndDate</div>
            </div>
            @include('common.date_picker', ['id' => 'inputEndDate', 'name' => 'end_date', 'value' => (isset($search) && isset($search["end_date"])) ? $search["end_date"] : '', 'format' => 'yyyy-mm-dd hh:ii:ss', ])
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">Search</button>
    </div>
</div>
{!! Form::close() !!}