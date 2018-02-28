<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: search.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 08:55:00
 */
?>

<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="inputIp">IP</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">IP</div>
            </div>
            <input name="ip" type="text" class="form-control" id="inputIp" placeholder="ip" @if(isset($search) && isset($search['ip'])) value="{{ $search['ip'] or '' }}" @endif >
        </div>
    </div>
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
        <label class="sr-only" for="selectProvince">Province</label>
        <div class="form-group mb-2">
            <select name="province_id" id="selectProvince" class="form-control">
                <option selected value="">Province</option>
                @foreach($provinceList as $province)
                    <option value="{{ $province['id'] or 0 }}" @if(isset($search) && isset($search['area_id']) &&  $search['area_id'] == $province['id']) selected @endif >{{ $province['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <button id="searchButton" type="submit" class="btn btn-outline-primary mb-2">Search</button>
    </div>
</div>
