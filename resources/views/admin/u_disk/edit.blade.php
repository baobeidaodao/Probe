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
    {!! Form::open(['method' => 'patch', 'route' => ['u-disk.update', $uDisk['id'], ], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputUuid">uuid</label>
            <input name="uuid" type="text" class="form-control" id="inputUuid" value="{{ $uDisk['uuid'] or '' }}" placeholder="UUID">
        </div>
        <label for="">Area</label>
        @include('common.area', ['for' => 'Edit' . $uDisk['id'], 'area_id' => $uDisk['user_area_id'], 'province_id' => $uDisk['user_province_id'], 'city_id' => $uDisk['user_city_id'],])
        <div class="form-group">
            <label for="selectUserId{{$uDisk['id']}}">人员</label>
            <select name="user_id" class="form-control" id="selectUserId{{$uDisk['id']}}">
                @foreach($userList as $user)
                    @if($user['city_id'] == $uDisk['user_city_id'])
                        <option value="{{ $user['id'] or 0 }}" @if($user['id'] == $uDisk['user_id']) selected @endif >{{ $user['name'] or '' }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectOperatorId">operator_id</label>
            <select name="operator_id" class="form-control" id="selectOperatorId">
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}" @if($operator['id'] == $uDisk['operator_id']) selected @endif >{{ $operator['name'] or '' }}</option>
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
<script>
    $(function () {
        $("#selectProvinceEdit{{$uDisk['id']}}").change(function () {
            var selectUserOptionHtml = '<option value="">Choose...</option>';
            var provinceId = $(this).val();
            // alert(provinceId);
            $.each(userList, function (index, value, array) {
                // alert(value['id']);
                if (value['province_id'] == provinceId) {
                    selectUserOptionHtml += '<option value="' + value['id'] + '">' + value['name'] + '</option>';
                }
            });
            $("#selectUserId{{$uDisk['id']}}").html(selectUserOptionHtml);
        });
        $("#selectCityEdit{{$uDisk['id']}}").change(function () {
            var selectUserOptionHtml = '<option value="">Choose...</option>';
            var cityId = $(this).val();
            // alert(cityId);
            $.each(userList, function (index, value, array) {
                // alert(value['id']);
                if (value['city_id'] == cityId) {
                    selectUserOptionHtml += '<option value="' + value['id'] + '">' + value['name'] + '</option>';
                }
            });
            $("#selectUserId{{$uDisk['id']}}").html(selectUserOptionHtml);
        });
    });
</script>