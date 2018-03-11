<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: city.blade.php
 * Author  : Li Tao
 * DateTime: 2018-03-09 20:00:00
 */
?>

@extends('admin.index')

@section('main')
    {!! Form::open(['id' => 'searchForm', 'method' => 'POST', 'url' => 'admin/statistics/province', 'data-for' => $form, ]) !!}
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
                <div class="card @if(!isset($summary['user_count']) || empty($summary['user_count'])) border-danger @else border-success  @endif mb-3">
                    <div class="card-header">总计</div>
                    <div class="card-body text-dark">
                        <h5 class="card-title">测试人员数量：{{ $summary['user_count'] or '' }}</h5>
                        <h5 class="card-title">活跃 U 盾数量：{{ $summary['u_disk_count'] or '' }}</h5>
                        <h5 class="card-title">上报数据条数：{{ $summary['report_count'] or '' }}</h5>
                    </div>
                </div>
                @foreach($statisticsList as $statistics)
                    <div class="card @if(!isset($statistics['summary']['report_count']) || empty($statistics['summary']['report_count'])) border-danger @else border-success  @endif mb-3">
                        <div class="card-header">
                            <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#viewUser{{ $statistics['summary']['user_id'] or '' }}">
                                {{ $statistics['summary']['user_name'] or '' }}
                            </button>
                        </div>
                        <div class="card-body text-dark">
                            <h5 class="card-title">部门：{{ $statistics['summary']['user_department'] or '' }}</h5>
                            <h5 class="card-title">电话：{{ $statistics['summary']['user_phone'] or '' }}</h5>
                            <h5 class="card-title">上报：{{ $statistics['summary']['report_count'] or '' }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    @foreach($statisticsList as $statistics)
        <div class="modal fade bd-example-modal-lg" id="viewUser{{ $statistics['summary']['user_id'] or '' }}" tabindex="-1" role="dialog" aria-labelledby="viewUser{{ $statistics['summary']['user_id'] or '' }}Title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">姓名</th>
                                    <th scope="col">部门</th>
                                    <th scope="col">电话</th>
                                    <th scope="col">UUID</th>
                                    <th scope="col">运营商</th>
                                    <th scope="col">日期</th>
                                    <th scope="col">统计</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($statistics['report_list'] as $report)
                                    <tr>
                                        <td>{{ $statistics['summary']['user_id'] or '' }}</td>
                                        <td>{{ $statistics['summary']['user_name'] or '' }}</td>
                                        <td>{{ $statistics['summary']['user_department'] or '' }}</td>
                                        <td>{{ $statistics['summary']['user_phone'] or '' }}</td>
                                        <td>{{ $report['uuid'] or '' }}</td>
                                        <td>{{ $report['report_operator'] or '' }}</td>
                                        <td>{{ $report['report_date'] or '' }}</td>
                                        <td>1</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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
    </script>
@endsection
