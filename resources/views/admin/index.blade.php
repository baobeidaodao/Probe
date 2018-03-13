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
            @include('common.navbar')
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @section('main')
                @show
            </main>
        </div>
    </div>
@endsection
