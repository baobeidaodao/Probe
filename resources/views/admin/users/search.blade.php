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
        <label class="sr-only" for="searchInputName">User</label>
        <div class="input-group mb-2">
            <div class="input-group-prepend sr-only">
                <div class="input-group-text">User</div>
            </div>
            <input name="name" type="text" class="form-control" id="searchInputName" placeholder="name" @if(isset($search) && isset($search['name'])) value="{{ $search['name'] or '' }}" @endif >
        </div>
    </div>
    @include('common.area', ['for' => 'search', 'area_id' => (isset($search) && isset($search['area_id'])) ? $search['area_id'] : '', ])
    <div class="col-auto">
        <label class="sr-only" for="searchSelectDepartment">Department</label>
        <div class="form-group mb-2">
            <select name="department_id" id="searchSelectDepartment" class="form-control">
                <option value="">Department</option>
                @foreach($departmentList as $department)
                    <option value="{{ $department['id'] }}" @if(isset($search) && isset($search['department_id']) && $department['id'] == $search['department_id']) selected @endif >{{ $department['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <button id="searchButton" type="submit" class="btn btn-outline-primary mb-2">Search</button>
    </div>
</div>
