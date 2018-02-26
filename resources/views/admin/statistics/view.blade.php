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
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Ip</th>
                    <th scope="col">Operator</th>
                    <th scope="col">Province</th>
                    <th scope="col">Probe Type</th>
                </tr>
                </thead>
                <tbody>
                @foreach($statistics['report'] as $report)
                    <tr>
                        <th scope="row">{{ $report['id'] or 0 }}</th>
                        <td>{{ $report['ip'] or '' }}</td>
                        <td>{{ $report['operator'] or '' }}</td>
                        <td>{{ $report['province'] or '' }}</td>
                        <td data-probe-type="{{ $report['probe_type'] or '' }}">@if($report['probe_type'] == 1) 自有 @else 公有 @endif</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>

