<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: view.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-26 15:27:00
 */
?>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="inputIp">Ip</label>
            <input type="text" class="form-control" id="inputIp" value="{{ $report['ip'] or '' }}" placeholder="Ip" readonly>
        </div>
        <div class="form-group">
            <label for="inputOperator">运营商</label>
            <input type="text" class="form-control" id="inputOperator" value="{{ $report['report_operator'] or '' }}" placeholder="运营商" readonly>
        </div>
        <div class="form-group">
            <label for="inputProvince">省</label>
            <input type="text" class="form-control" id="inputProvince" value="{{ $report['report_province'] or '' }}" placeholder="省" readonly>
        </div>
        <div class="form-group">
            <label for="inputProbeType">上报类型</label>
            <input type="text" class="form-control" id="inputProbeType" value=" @if($report['probe_type'] == 1) 自有 @else 公有 @endif " placeholder="上报类型" readonly>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
    </div>
</div>

