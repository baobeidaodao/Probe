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
    {!! Form::open(['id' => 'inputForm', 'method'=> 'POST', 'route' => 'ip.store']) !!}
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div id="inputTips"></div>
        <div class="form-group">
            <label for="inputStartIp">起始IP</label>
            <input name="start_ip" type="text" class="form-control" id="inputStartIp" placeholder="起始IP">
        </div>
        <div class="form-group">
            <label for="inputEndIp">结束IP</label>
            <input name="end_ip" type="text" class="form-control" id="inputEndIp" placeholder="结束IP">
        </div>
        <div class="form-group">
            <label for="selectOperator">运营商</label>
            <select name="operator_id" class="form-control" id="selectOperator">
                <option value="">运营商</option>
                @foreach($operatorList as $operator)
                    <option value="{{ $operator['id'] or 0 }}">{{ $operator['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="selectProvince">省</label>
            <select name="province_id" class="form-control" id="selectProvince">
                <option value="">省</option>
                @foreach($provinceList as $province)
                    <option value="{{ $province['id'] or 0 }}">{{ $province['name'] or '' }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        <button id="inputSubmit" type="button" class="btn btn-primary">保存</button>
    </div>
    {!! Form::close() !!}
</div>
<script>
    $(function () {
        $("#inputSubmit").click(function () {
            var startIp = $("#inputStartIp").val();
            var endIp = $("#inputEndIp").val();
            $.ajax({
                url: '/admin/ip/check?startIp=' + startIp + '&endIp=' + endIp,
                type: "GET",
                async: false,
                success: function (result) {
                    var data;
                    if (typeof(result) === 'string') {
                        data = JSON.parse(result);
                    } else {
                        data = result;
                    }
                    if (data['count'] > 0) {
                        var tips = '';
                        var ipList = data['ipList'];
                        var ipTips = '';
                        $.each(ipList, function (index, value, array) {
                            ipTips += value['start_ip'] + ' - ' + value['end_ip'] + '<br>'
                        });
                        tips += '你填入的IP段<br>' +
                            startIp + ' - ' + endIp + '<br>' +
                            '与 ' + data['count'] + ' 条记录有冲突：<br>' +
                            ipTips +
                            '无法添加<hr>';
                        $("#inputTips").html(tips);
                        return false;
                    } else {
                        // alert(data['count']);
                        $("#inputSubmit").attr('type', 'submit');
                        $("#inputForm").submit();
                    }
                }
            });
        });
    });
</script>