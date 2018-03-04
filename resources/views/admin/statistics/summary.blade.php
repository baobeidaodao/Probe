<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-07 07:34:00
 */
?>

<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputUuid">UUID</label>
        <div class="input-group mb-2">
            <div class="sr-only input-group-prepend">
                <div class="input-group-text">UUID</div>
            </div>
            <input name="uuid" type="text" class="form-control" id="inputUuid" placeholder="uuid" @if(isset($search) && isset($search['uuid'])) value="{{ $search['uuid'] or '' }}" @endif >
        </div>
    </div>
    @include('common.area', ['for' => 'search', 'area_id' => (isset($search) && isset($search['area_id'])) ? $search['area_id'] : '', 'province_id' => (isset($search) && isset($search['province_id'])) ? $search['province_id'] : '', 'city_id' => (isset($search) && isset($search['city_id'])) ? $search['city_id'] : '', ])
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
            <div class="sr-only input-group-prepend">
                <div class="input-group-text">开始时间</div>
            </div>
            @include('common.date_picker', ['id' => 'inputStartDate', 'name' => 'start_date', 'placeholder' => '开始时间', 'value' => (isset($search) && isset($search["start_date"])) ? $search["start_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="inputEndDate">结束时间</label>
        <div class="input-group mb-2">
            <div class="sr-only input-group-prepend">
                <div class="input-group-text">结束时间</div>
            </div>
            @include('common.date_picker', ['id' => 'inputEndDate', 'name' => 'end_date', 'placeholder' => '结束时间', 'value' => (isset($search) && isset($search["end_date"])) ? $search["end_date"] : '', 'format' => 'yyyy-mm-dd', ])
        </div>
    </div>
    <div class="col-auto">
        <button id="searchButton" type="submit" class="btn btn-outline-primary mb-2">搜索</button>
        <button id="summaryButton" type="submit" class="btn btn-outline-primary mb-2">汇总</button>
    </div>
</div>

<script>
    $(function () {
        $("#searchButton").click(function () {
            $("#searchFormPage").val(1);
            $("#searchForm").attr('action', '{{ url('/admin/statistics/search') }}');
        });
        $("#summaryButton").click(function () {
            $("#searchFormPage").val(1);
            $("#searchForm").attr('action', '{{ url('/admin/statistics/summary') }}');
        });
    });
</script>