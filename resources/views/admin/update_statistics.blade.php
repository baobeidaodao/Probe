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
        <label class="sr-only" for="inputStartDate">StartDate</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">StartDate</div>
            </div>
            @include('common.date_picker', ['id' => 'inputStartDate', 'name' => 'start_date', 'value' => (isset($update) && isset($update["start_date"])) ? $update["start_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">EndDate</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">EndDate</div>
            </div>
            @include('common.date_picker', ['id' => 'inputEndDate', 'name' => 'end_date', 'value' => (isset($update) && isset($update["end_date"])) ? $update["end_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">Update</button>
    </div>
</div>
{!! Form::close() !!}
