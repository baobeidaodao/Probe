<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: edit.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 00:15:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'patch', 'route' => ['users.update', $user->id], ]) !!}
    <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group row" @if(Auth::id() == $user->id) style="display: none;" @endif>
            <label for="editInputName{{ $user->id or 0 }}" class="col-sm-2 col-form-label">姓名</label>
            <div class="col-sm-10">
                <input name="name" type="text" class="form-control" id="editInputName{{ $user->id or 0 }}" value="{{ $user->name or '' }}" placeholder="姓名" @if($user->name === 'admin') readonly @endif>
            </div>
        </div>
        <div class="form-group row" @if(Auth::id() == $user->id) style="display: none;" @endif>
            <label for="editInputEmail{{ $user->id or 0 }}" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input name="email" type="email" class="form-control" id="editInputEmail{{ $user->id or 0 }}" value="{{ $user->email or '' }}" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
            <label for="editInputPassword{{ $user->id or 0 }}" class="col-sm-2 col-form-label">密码</label>
            <div class="col-sm-10">
                <input name="password" type="password" class="form-control" id="editInputPassword{{ $user->id or 0 }}" value="" placeholder="密码">
            </div>
        </div>
        <div class="form-group row" @if(Auth::id() == $user->id) style="display: none;" @endif>
            <label for="editInputPhone{{ $user->id or 0 }}" class="col-sm-2 col-form-label">电话</label>
            <div class="col-sm-10">
                <input name="phone" type="text" class="form-control" id="editInputPhone{{ $user->id or 0 }}" value="{{ $user->phone or '' }}" placeholder="电话">
            </div>
        </div>
        <div class="form-group row" @if(Auth::id() == $user->id) style="display: none;" @endif>
            <label for="editSelectLevel{{ $user->id or 0 }}" class="col-sm-2 col-form-label">级别</label>
            <div class="col-sm-10">
                <select name="level" class="form-control" id="editSelectLevel{{ $user->id or 0 }}">
                    <option value="">选择</option>
                    @if(Auth::id() == $user->id)
                        <option value="{{ $user->level or 0 }}" selected></option>
                    @endif
                    @foreach($userLevelList as $userLevel)
                        <option value="{{ $userLevel['id'] or 0 }}" @if($userLevel['id'] == $user->level) selected @endif >{{ $userLevel['name'] or '' }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row" @if(Auth::id() == $user->id) style="display: none;" @endif>
            <label for="" class="col-sm-2 col-form-label">Area</label>
            @include('common.area', ['for' => 'Edit' . $user->id, 'area_id' => $user->area_id, 'class' => 'col-sm-10', ])
        </div>
        <div class="form-group row" @if(Auth::id() == $user->id) style="display: none;" @endif>
            <label for="selectDepartmentEdit{{ $user->id or 0 }}" class="col-sm-2 col-form-label">部门</label>
            <div class="col-sm-10">
                <select name="department_id" class="form-control" id="selectDepartmentEdit{{ $user->id or 0 }}">
                    @if(count($departmentList)>1)
                    @endif
                    <option value="">选择</option>
                    @foreach($departmentList as $department)
                        @if($department['area_id'] == $user->area_id)
                            <option value="{{ $department['id'] or 0 }}" @if($department['id'] == $user->department_id) selected @endif >{{ $department['name'] or '' }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row" @if(Auth::id() == $user->id) style="display: none;" @endif>
            <label class="col-sm-2 col-form-label">角色</label>
            <div class="col-sm-10">
                @foreach($roles as $role)
                    <div class="form-check">
                        {!! Form::checkbox('role[]', $role->id, $user->hasRole($role->name) ? true:false) !!}
                        {{ $role->display_name or $role->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button id="editFormSubmit{{ $user->id or 0 }}" type="submit" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
<script>
    $(function () {
        $("#editFormSubmit{{ $user->id or 0 }}").click(function () {
            var editInputName{{ $user->id or 0 }} = $("#editInputName{{ $user->id or 0 }}").val();
            var editInputEmail{{ $user->id or 0 }} = $("#editInputEmail{{ $user->id or 0 }}").val();
            var editSelectLevel{{ $user->id or 0 }} = $("#editSelectLevel{{ $user->id or 0 }}").val();
            var selectProvinceEdit{{ $user->id or 0 }} = $("#selectProvinceEdit{{ $user->id or 0 }}").val();
            var selectCityEdit{{ $user->id or 0 }} = $("#selectCityEdit{{ $user->id or 0 }}").val();
            if (editInputName{{ $user->id or 0 }} == '') {
                alert('姓名不可为空');
                return false;
            }
            if (editInputEmail{{ $user->id or 0 }} == '') {
                alert('邮箱不可为空');
                return false;
            }
            if (editSelectLevel{{ $user->id or 0 }} == '') {
                alert('级别不可为空');
                return false;
            }
            if (selectProvinceEdit{{ $user->id or 0 }} == '') {
                alert('省份不可为空');
                return false;
            }
            if (selectCityEdit{{ $user->id or 0 }} == '') {
                alert('城市不可为空');
                return false;
            }
        });
    });
</script>
<script>
    $(function () {
        $("#selectProvinceEdit{{ $user->id or 0 }}").change(function () {
            var selectUserOptionHtml = '<option value="">Choose...</option>';
            var provinceId = $(this).val();
            // alert(provinceId);
            $.each(departmentList, function (index, value, array) {
                // alert(value['id']);
                if (value['area_id'] == provinceId) {
                    selectUserOptionHtml += '<option value="' + value['id'] + '">' + value['name'] + '</option>';
                }
            });
            $("selectDepartmentEdit{{ $user->id or 0 }}").html(selectUserOptionHtml);
        });
        $("#selectCityEdit{{ $user->id or 0 }}").change(function () {
            var selectUserOptionHtml = '<option value="">Choose...</option>';
            var cityId = $(this).val();
            // alert(cityId);
            $.each(departmentList, function (index, value, array) {
                // alert(value['id']);
                if (value['area_id'] == cityId) {
                    selectUserOptionHtml += '<option value="' + value['id'] + '">' + value['name'] + '</option>';
                }
            });
            $("selectDepartmentEdit{{ $user->id or 0 }}").html(selectUserOptionHtml);
        });
    });
</script>