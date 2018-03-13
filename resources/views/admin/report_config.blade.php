<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: update.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-27 17:33:00
 */
?>

{!! Form::open(['method' => 'POST', 'url' => 'admin/update-report-config']) !!}
<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="selectOperatorIdLevel1">IP归属运营商</label>
        <div class="form-group mb-2">
            <select name="operator_id_level_1" id="selectOperatorIdLevel1" class="form-control">
                <option value="0">IP归属运营商</option>
                @foreach($ipOperatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if(isset($operatorIdLevel['operatorIdLevel1']) && $operatorIdLevel['operatorIdLevel1'] == $operator['id']) selected @endif >{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="selectOperatorIdLevel2">U盾配置运营商</label>
        <div class="form-group mb-2">
            <select name="operator_id_level_2" id="selectOperatorIdLevel2" class="form-control">
                <option value="0">U盾配置运营商</option>
                @foreach($uDiskOperatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if(isset($operatorIdLevel['operatorIdLevel2']) && $operatorIdLevel['operatorIdLevel2'] == $operator['id']) selected @endif >{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-outline-primary mb-2">更新</button>
    </div>
</div>
{!! Form::close() !!}
