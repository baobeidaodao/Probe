<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: update.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-27 17:33:00
 */
?>

{!! Form::open(['method' => 'GET', 'url' => 'admin/update-statistics']) !!}
<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputStartDate">开始时间</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">开始时间</div>
            </div>
            @include('common.date_picker', ['id' => 'inputStartDate', 'name' => 'start_date', 'placeholder' => '开始时间', 'value' => (isset($update) && isset($update["start_date"])) ? $update["start_date"] : '', 'format' => 'yyyy-mm-dd',])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">结束时间</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">结束时间</div>
            </div>
            @include('common.date_picker', ['id' => 'inputEndDate', 'name' => 'end_date', 'placeholder' => '结束时间', 'value' => (isset($update) && isset($update["end_date"])) ? $update["end_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">更新</button>
    </div>
</div>
{!! Form::close() !!}
