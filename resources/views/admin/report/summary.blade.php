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
    {!! Form::open(['id' => 'searchForm', 'method' => 'POST', 'url' => 'admin/report/group']) !!}
    <div class="card">
        <div class="card-header">
            @include('admin.report.search')
        </div>
        <div class="card-body">
            <div class="card-columns">
                <div class="card @if(!isset($summary['report_count']) || empty($summary['report_count'])) border-danger @else border-success  @endif mb-3">
                    <div class="card-header">总计</div>
                    <div class="card-body text-dark">
                        <h5 class="card-title">上报数据条数：{{ $summary['report_count'] or '' }}</h5>
                        @if($summary['report_count'] > 0)
                            <button type="button" class="btn btn-outline-success btn-sm export-button" data-id="0">
                                下载
                            </button>
                        @endif
                    </div>
                </div>
                @foreach($reportList as $report)
                    <div class="card @if(!isset($report['report_count']) || empty($report['report_count'])) border-danger @else border-success @endif mb-3">
                        <div class="card-header">{{ $report['province'] or '' }}</div>
                        <div class="card-body text-dark">
                            <h5 class="card-title">上报数据条数：{{ $report['report_count'] or '' }}</h5>
                            <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#view{{ $report['province_id'] or '' }}">
                                查看
                            </button>
                            @if($report['report_count'] > 0)
                                <button type="button" class="btn btn-outline-success btn-sm export-button" data-id="{{ $report['province_id'] or 0 }}">
                                    下载
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <input id="export_province_id" type="hidden" name="export_province_id" value="0">
    {!! Form::close() !!}
    @foreach($reportList as $report)
        <div class="modal fade bd-example-modal-lg" id="view{{ $report['province_id'] or '' }}" tabindex="-1" role="dialog" aria-labelledby="view{{ $report['province_id'] or '' }}Title" aria-hidden="true">
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
                                    <th scope="col">IP</th>
                                    <th scope="col">所属省</th>
                                    <th scope="col">所属运营商</th>
                                    <th scope="col">测试时间</th>
                                    <th scope="col">U盾省</th>
                                    <th scope="col">U盾市</th>
                                    <th scope="col">U盾运营商</th>
                                    <th scope="col">类型</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($report['report_list'] as $item)
                                    <tr>
                                        <td>{{ $item['ip'] or '' }}</td>
                                        <td>{{ $item['report_province'] or '' }}</td>
                                        <td>{{ $item['report_operator'] or '' }}</td>
                                        <td>{{ $item['report_date'] or '' }}</td>
                                        <td>{{ $item['province'] or '' }}</td>
                                        <td>{{ $item['city'] or '' }}</td>
                                        <td>{{ $item['operator'] or '' }}</td>
                                        <td>@if($item['probe_type'] == 1) 自有 @else 公有 @endif</td>
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
        $("#searchButton").click(function () {
            var provinceId = $("#selectProvince").val();
            var cityId = $("#selectCity").val();
            if (cityId !== '' && parseInt(cityId) > 0) {
                $("#searchForm").attr('action', '{{ url('/admin/report/province') }}');
            } else if (provinceId !== '' && parseInt(provinceId) > 0) {
                $("#searchForm").attr('action', '{{ url('/admin/report/province') }}');
            }
        });
        $(".export-button").click(function () {
            var provinceId = $(this).attr('data-id');
            $("#export_province_id").val(provinceId);
            $("#searchForm").attr('action', '{{ url('/admin/report/export') }}');
            $("#searchForm").submit();
        });
    </script>
@endsection
