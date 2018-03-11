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
        <label class="sr-only" for="selectReportType">探针方式</label>
        <div class="form-group mb-2">
            <select name="probe_type" id="selectReportType" class="form-control">
                <option value="">探针方式</option>
                <option value="1" @if(isset($search) && isset($search['probe_type']) && $search['probe_type'] == 1) selected @endif >自有</option>
                <option value="2" @if(isset($search) && isset($search['probe_type']) && $search['probe_type'] == 2) selected @endif >公有</option>
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputIp">Ip</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">Ip</div>
            </div>
            <input name="ip" type="text" class="form-control" id="inputIp" placeholder="ip" @if(isset($search) && isset($search['ip'])) value="{{ $search['ip'] or '' }}" @endif >
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="selectReportProvince">IP归属省</label>
        <div class="form-group mb-2">
            <select name="report_province_id" id="selectReportProvince" class="form-control">
                <option value="">IP归属省</option>
                @foreach($provinceList as $province)
                    <option value="{{ $province['id'] or 0 }}" @if(isset($search) && isset($search['report_province_id']) && $search['report_province_id'] == $province['id']) selected @endif >{{ $province['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="selectReportOperator">IP运营商</label>
        <div class="form-group mb-2">
            <select name="report_operator_id" id="selectReportOperator" class="form-control">
                <option selected value="">IP运营商</option>
                @foreach($reportOperatorList as $reportOperator)
                    <option value="{{ $reportOperator['id'] or 0 }}" @if(isset($search) && isset($search['report_operator_id']) && $search['report_operator_id'] == $reportOperator['id']) selected @endif >{{ $reportOperator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
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
            @include('common.date_picker', ['id' => 'inputStartDate', 'name' => 'start_date', 'placeholder' => '开始时间', 'value' => (isset($search) && isset($search["start_date"])) ? $search["start_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">结束时间</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">结束时间</div>
            </div>
            @include('common.date_picker', ['id' => 'inputEndDate', 'name' => 'end_date', 'placeholder' => '结束时间', 'value' => (isset($search) && isset($search["end_date"])) ? $search["end_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <button id="searchButton" type="submit" class="btn btn-outline-primary mb-2">搜索</button>
    </div>
</div>
