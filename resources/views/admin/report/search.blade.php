<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: search.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-26 13:43:00
 */
?>

<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputUuid">UUID</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">UUID</div>
            </div>
            <input name="uuid" type="text" class="form-control" id="inputUuid" placeholder="uuid" @if(isset($search) && isset($search['uuid'])) value="{{ $search['uuid'] or '' }}" @endif >
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputIp">Ip</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">Ip</div>
            </div>
            <input name="ip" type="text" class="form-control" id="inputIp" placeholder="ip" @if(isset($search) && isset($search['ip'])) value="{{ $search['ip'] or '' }}" @endif >
        </div>
    </div>
    @include('common.area', ['for' => 'search', 'area_id' => (isset($search) && isset($search['area_id'])) ? $search['area_id'] : '', 'province_id' => (isset($search) && isset($search['province_id'])) ? $search['province_id'] : '', 'city_id' => (isset($search) && isset($search['city_id'])) ? $search['city_id'] : '', ])
    <div class="col-auto">
        <label class="sr-only" for="selectOperator">Operator</label>
        <div class="form-group mb-2">
            <select name="operator_id" id="selectOperator" class="form-control">
                <option selected value="">Operator</option>
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if(isset($search) && isset($search['operator_id']) && $search['operator_id'] == $operator['id']) selected @endif >{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputStartDate">StartDate</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">StartDate</div>
            </div>
            @include('common.date_picker', ['id' => 'inputStartDate', 'name' => 'start_date', 'value' => (isset($search) && isset($search["start_date"])) ? $search["start_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">EndDate</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">EndDate</div>
            </div>
            @include('common.date_picker', ['id' => 'inputEndDate', 'name' => 'end_date', 'value' => (isset($search) && isset($search["end_date"])) ? $search["end_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">Search</button>
    </div>
</div>
