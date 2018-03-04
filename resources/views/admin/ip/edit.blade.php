<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: edit.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 14:04:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'patch', 'route' => ['ip.update', $ip['id'], ], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputStartIp">起始IP</label>
            <input name="start_ip" type="text" class="form-control" id="inputStartIp" value="{{ $ip['start_ip'] or '' }}" placeholder="起始IP">
        </div>
        <div class="form-group">
            <label for="inputEndIp">结束IP</label>
            <input name="end_ip" type="text" class="form-control" id="inputEndIp" value="{{ $ip['end_ip'] or '' }}" placeholder="结束IP">
        </div>
        <div class="form-group">
            <label for="selectOperator">运营商</label>
            <select name="operator_id" class="form-control" id="selectOperator">
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if($ip['operator_id'] == $operator['id']) selected @endif >{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectProvince">省</label>
            <select name="province_id" class="form-control" id="selectProvince">
                @foreach($provinceList as $province)
                    <option value="{{ $province['id'] or 0 }}" @if($ip['area_id'] == $province['id']) selected @endif >{{ $province['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
