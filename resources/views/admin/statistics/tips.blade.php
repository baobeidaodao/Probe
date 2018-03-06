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
            @if(Auth::user()->level <= \App\Models\UserLevel::LEVEL_PROVINCIAL_MANAGER)
                <a class="click-city" href="javascript:void(0);" data-city-id="{{ $city['id'] or 0 }}">{{ $city['name'] or '' }}</a>上报{{ $city['number'] or '' }}次；
            @elseif(Auth::user()->level == \App\Models\UserLevel::LEVEL_MUNICIPAL_MANAGER && Auth::user()->city_id == $city['id'])
                <a class="click-city" href="javascript:void(0);" data-city-id="{{ $city['id'] or 0 }}">{{ $city['name'] or '' }}</a>上报{{ $city['number'] or '' }}次；
            @else
                {{ $city['name'] or '' }}上报{{ $city['number'] or '' }}次；
            @endif
        @endforeach
    </div>
</div>

<script>
    $(".click-city").click(function () {
        var cityId = $(this).attr('data-city-id');
        $("#selectCitysearch").val(cityId);
        $("#searchForm").submit();
    });
</script>