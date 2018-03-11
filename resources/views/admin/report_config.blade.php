<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: update.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-27 17:33:00
 */
?>

{!! Form::open(['method' => 'POST', 'url' => 'admin/report-config']) !!}
<div class="form-row align-items-center">
    @include('common.area', ['area_id' => (isset($search) && isset($search['area_id'])) ? $search['area_id'] : '', 'province_id' => (isset($search) && isset($search['province_id'])) ? $search['province_id'] : '', 'city_id' => (isset($search) && isset($search['city_id'])) ? $search['city_id'] : '', ])
    <div class="col-auto">
        <label class="sr-only" for="selectOperator">运营商</label>
        <div class="form-group mb-2">
            <select name="operator_id" id="selectOperator" class="form-control">
                <option selected value="">运营商</option>
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if(isset($search) && isset($search['operator_id']) && $search['operator_id'] == $operator['id']) selected @endif >{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputStartDate">开始时间</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">开始时间</div>
            </div>
            @include('common.date_picker', ['id' => 'configInputStartDate', 'name' => 'start_date', 'placeholder' => '开始时间', 'value' => (isset($update) && isset($update["start_date"])) ? $update["start_date"] : '', 'format' => 'yyyy-mm-dd',])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">结束时间</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">结束时间</div>
            </div>
            @include('common.date_picker', ['id' => 'configInputEndDate', 'name' => 'end_date', 'placeholder' => '结束时间', 'value' => (isset($update) && isset($update["end_date"])) ? $update["end_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">更新</button>
    </div>
</div>
{!! Form::close() !!}
