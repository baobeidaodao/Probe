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
    {!! Form::open(['method'=> 'POST', 'route' => 'ip.store']) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputIp">ip</label>
            <input name="ip" type="text" class="form-control" id="inputIp" placeholder="Enter Ip">
        </div>
        <div class="form-group">
            <label for="inputMask">mask</label>
            <input name="mask" type="text" class="form-control" id="inputMask" placeholder="Enter Mask">
        </div>
        <div class="form-group">
            <label for="selectType">Type</label>
            <select name="type" class="form-control" id="selectType">
                <option selected>Choose...</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
            </select>
        </div>
        <div class="form-group">
            <label for="selectOperator">Operator</label>
            <select name="operator_id" class="form-control" id="selectOperator">
                <option selected>Choose...</option>
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}">{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectProvince">Province</label>
            <select name="province_id" class="form-control" id="selectProvince">
                <option selected>Choose...</option>
                @foreach($provinceList as $province)
                    <option value="{{ $province['id'] or 0 }}">{{ $province['name'] or '' }}</option>
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
