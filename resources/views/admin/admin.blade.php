<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: admin.blade.php
 * Author  : Li Tao
 * DateTime: 2018-03-13 11:10:00
 */
?>

@extends('admin.index')

@section('main')
    @role('admin')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">控制台</h1>
    </div>
    <div class="card">
        <div class="card-header">
            更新数据报表
        </div>
        <div class="card-body">
            @include('admin.update_statistics')
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-header">
            数据报表配置
        </div>
        <div class="card-body">
            @include('admin.report_config')
        </div>
    </div>
    @endrole
@endsection
