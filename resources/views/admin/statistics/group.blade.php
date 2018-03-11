<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-07 07:34:00
 */
?>

@extends('admin.index')

@section('main')
    {!! Form::open(['id' => 'searchForm', 'method' => 'POST', 'url' => 'admin/statistics/group', 'data-for' => $form, ]) !!}
    <div class="card">
        <div class="card-header">
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
                    <button id="summaryButton" type="submit" class="btn btn-outline-primary mb-2">汇总</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-columns">
                <div class="card @if(!isset($summary['reportCount']) || empty($summary['reportCount'])) border-danger @else border-success  @endif mb-3">
                    <div class="card-header">总计</div>
                    <div class="card-body text-dark">
                        <h5 class="card-title">安装 U 盾数量：{{ $summary['installUDiskCount'] or '' }}</h5>
                        <h5 class="card-title">活跃 U 盾数量：{{ $summary['reportUDiskCount'] or '' }}</h5>
                        <h5 class="card-title">上报数据条数：{{ $summary['reportCount'] or '' }}</h5>
                    </div>
                </div>
                @foreach($statisticsList as $statistics)
                    <a href="javascript:void(0);" class="chooseProvince" data-id="{{ $statistics['provinceId'] or 0 }}">
                        <div class="card @if(!isset($statistics['reportCount']) || empty($statistics['reportCount'])) border-danger @else border-success  @endif mb-3">
                            <div class="card-header">{{ $statistics['provinceName'] or '' }}</div>
                            <div class="card-body text-dark">
                                <h5 class="card-title">安装 U 盾数量：{{ $statistics['installUDiskCount'] or '' }}</h5>
                                <h5 class="card-title">活跃 U 盾数量：{{ $statistics['reportUDiskCount'] or '' }}</h5>
                                <h5 class="card-title">上报数据条数：{{ $statistics['reportCount'] or '' }}</h5>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <script>
        $("#summaryButton").click(function () {
            var provinceId = $("#selectProvince").val();
            var cityId = $("#selectCity").val();
            if (cityId !== '' && parseInt(cityId) > 0) {
                $("#searchForm").attr('action', '{{ url('/admin/statistics/city') }}');
            } else if (provinceId !== '' && parseInt(provinceId) > 0) {
                $("#searchForm").attr('action', '{{ url('/admin/statistics/province') }}');
            }
        });
        $(".chooseProvince").click(function () {
            var provinceId = $(this).attr('data-id');
            $("#selectProvince").val(provinceId);
            $("#searchForm").attr('action', '{{ url('/admin/statistics/province') }}');
            $("#searchForm").submit();
        });
    </script>
@endsection
