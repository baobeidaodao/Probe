<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: create.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 00:04:00
 */
?>

<div class="modal-content">
    {!! Form::open(['method' => 'POST', 'route'=> 'users.store']) !!}
    <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="createInputName">姓名</label>
            <input name="name" type="text" class="form-control" id="createInputName" placeholder="姓名">
        </div>
        <div class="form-group">
            <label for="createInputEmail">Email</label>
            <input name="email" type="email" class="form-control" id="createInputEmail" placeholder="Email">
        </div>
        <input type="hidden" name="password" value="123456">
        <div class="form-group">
            <label for="createInputPhone">电话</label>
            <input name="phone" type="text" class="form-control" id="createInputPhone" placeholder="电话">
        </div>
        <div class="form-group">
            <label for="createSelectLevel">级别</label>
            <select name="level" class="form-control" id="createSelectLevel">
                <option value="">选择</option>
                @foreach($userLevelList as $userLevel)
                    <option value="{{ $userLevel['id'] or 0 }}">{{ $userLevel['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <label for="">Area</label>
        @include('common.area', ['for' => 'create', 'area_id' => '', ])
        <div class="form-group">
            <label for="selectDepartmentcreate">部门</label>
            <select name="department_id" class="form-control" id="selectDepartmentcreate">
                @if(count($departmentList)>1)
                @endif
                <option value="">选择</option>
                @foreach($departmentList as $department)
                    <option value="{{ $department['id'] or 0 }}">{{ $department['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>角色</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input name="role[]" class="form-check-input" type="checkbox" value="{{ $role->id or '' }}" id="createCheckbox{{ $loop->iteration }}">
                    <label class="form-check-label" for="createCheckbox{{ $loop->iteration }}">
                        {{ $role->display_name or $role->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button type="submit" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
