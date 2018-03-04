<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: search.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 14:53:00
 */

?>

<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputUser">人员</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">人员</div>
            </div>
            <input name="user_name" type="text" class="form-control" id="inputUser" placeholder="人员" @if(isset($search) && isset($search['user_name'])) value="{{ $search['user_name'] or '' }}" @endif >
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputStartDate">开始时间</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">开始时间</div>
            </div>
            @include('common.date_picker', ['id' => 'inputStartDate', 'name' => 'start_date', 'placeholder' => '开始时间', 'value' => (isset($search) && isset($search["start_date"])) ? $search["start_date"] : '', 'format' => 'yyyy-mm-dd hh:ii:ss', ])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">结束时间</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">结束时间</div>
            </div>
            @include('common.date_picker', ['id' => 'inputEndDate', 'name' => 'end_date', 'placeholder' => '结束时间', 'value' => (isset($search) && isset($search["end_date"])) ? $search["end_date"] : '', 'format' => 'yyyy-mm-dd hh:ii:ss', ])
        </div>
    </div>
    <div class="col-auto">
        <button id="searchButton" type="submit" class="btn btn-outline-primary mb-2">搜索</button>
    </div>
</div>
