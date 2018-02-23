<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: create_form.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-08 05:49:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method'=> 'POST', 'route' => 'department.store']) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputName">名称</label>
            <input name="name" type="text" class="form-control" id="inputName" placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="selectCityId">City</label>
            <select name="city_id" class="form-control" id="selectCityId">
                <option selected>Choose...</option>
                @foreach($cityList as $city)
                    <option value="{{ $city['id'] or 0 }}">{{ $city['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
    {!! Form::close() !!}
</div>
