<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: datepicker.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 13:37:00
 */

?>

<input id="{{ $id or '' }}" name="{{ $name or '' }}" class="form-control" type="text" value="{{ $value or '' }}" placeholder="{{ $name or '' }}">
<script>
    $('#{{ $id or '' }}').datetimepicker({
        format: "{{ $format or '' }}",
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
</script>