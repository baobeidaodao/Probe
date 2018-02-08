<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-06 11:58:00
 */
?>

@extends('html')

@section('body')
    @include('common.header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" id="v-pills-roles-tab" data-toggle="pill" href="{{ url('/admin/roles') }}" role="tab" aria-controls="v-pills-home" aria-selected="true">角色管理</a>
                    <a class="nav-link" id="v-pills-permissions-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">权限管理</a>
                    <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">人员管理</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">U盾管理</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">统计信息</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">数据查询</a>
                </div>
            </div>
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        人员管理人员管理人员管理人员管理人员管理人员管理人员管理人员管理人员管理人员管理人员管理人员管理人员管理人员管理
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        U盾管理U盾管理U盾管理U盾管理U盾管理U盾管理U盾管理U盾管理U盾管理U盾管理U盾管理U盾管理
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        统计信息统计信息统计信息统计信息统计信息统计信息统计信息统计信息统计信息统计信息统计信息统计信息统计信息统计信息
                    </div>
                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        数据查询数据查询数据查询数据查询数据查询数据查询数据查询数据查询数据查询数据查询数据查询数据查询数据查询数据查询
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection