<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: tips.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-27 17:59:00
 */
?>

<div class="card">
    <div class="card-header">
        {{ $tips['province']['name'] or '' }}上报{{ $tips['province']['number'] or '' }}次；
        <br>
        @foreach($tips['cityList'] as $city)
            {{ $city['name'] or '' }}上报{{ $city['number'] or '' }}次；
        @endforeach
    </div>
</div>
