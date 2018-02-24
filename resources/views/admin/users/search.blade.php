<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: search.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 08:55:00
 */
?>

{!! Form::open(['method'=> 'POST', 'url' => 'admin/users/search']) !!}
<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputName">User</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">User</div>
            </div>
            <input name="name" type="text" class="form-control" id="inputName" placeholder="name" @if(isset($search) && isset($search['name'])) value="{{ $search['name'] or '' }}" @endif >
        </div>
    </div>
    @include('common.area', ['for' => 'search', 'area_id' => (isset($search) && isset($search['area_id'])) ? $search['area_id'] : '', ])
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">Search</button>
    </div>
</div>
{!! Form::close() !!}
