<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: area.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 09:02:00
 */
$for = isset($for) ? $for : '';
$area_id = isset($area_id) ? $area_id : 0;
$areaMap = isset($areaMap) ? $areaMap : [];
$areaMapJson = json_encode($areaMap);
$province_id = 0;
$city_id = 0;
$area_level = 0;
foreach ($areaMap as $province) {
    if ($province['id'] == $area_id) {
        $area_level = $province['level'];
        $province_id = $area_id;
        break;
    } else {
        foreach ($province['sub_area'] as $city) {
            if ($city['id'] == $area_id) {
                $area_level = $city['level'];
                $province_id = $province['id'];
                $city_id = $area_id;
                break;
            }
        }
    }
}
?>
<script>
    var areaMapJson = '<?php echo $areaMapJson ?>';
    var areaMap = JSON.parse(areaMapJson);
    var areaId = '<?php echo $area_id ?>';
    var areaLevel = '<?php echo $area_level ?>';
</script>
<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="selectProvince{{ $for or '' }}">Province</label>
        <div class="form-group mb-2">
            <select name="province_id" id="selectProvince{{ $for or '' }}" class="form-control" onchange="changeProvince{{$for or ''}}();" @if(isset($readonly) && $readonly == true) readonly @endif >
                <option value="">Province</option>
                @foreach($areaMap as $province)
                    <option value="{{ $province['id'] }}" @if($province['id'] == $province_id) selected @endif >{{ $province['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="selectCity{{ $for or '' }}">City</label>
        <div class="form-group mb-2">
            <select name="city_id" class="form-control" id="selectCity{{ $for or '' }}" @if(isset($readonly) && $readonly == true) readonly @endif >
                <option value="">City</option>
                @foreach($areaMap as $province)
                    @if($province['id'] == $province_id)
                        @foreach($province['sub_area'] as $city)
                            <option value="{{ $city['id'] }}" @if($city['id'] == $city_id) selected @endif >{{ $city['name'] }}</option>
                        @endforeach
                    @endif
                @endforeach
            </select>
        </div>
    </div>
</div>
<script>
    function changeProvince{{$for or ''}}() {
        var selectedOption = $('#selectProvince{{ $for or "" }}').find(":selected");
        var provinceId = selectedOption.attr('value');
        changeCity{{$for or ''}}(provinceId);
    }

    function changeCity{{$for or ''}}(provinceId) {
        var cityList;
        for (var i = 0, l = areaMap.length; i < l; i++) {
            if (parseInt(provinceId) === parseInt(areaMap[i]['id'])) {
                cityList = areaMap[i]['sub_area'];
            }
        }
        setCity{{$for or ''}}(cityList);
    }

    function setCity{{$for or ''}}(cityList) {
        var cityOptionHtml = '';
        cityOptionHtml += '<option value="">City</option>';
        var cityId;
        var cityName;
        for (var i = 0, l = cityList.length; i < l; i++) {
            cityId = cityList[i]['id'];
            cityName = cityList[i]['name'];
            cityOptionHtml += '<option value="' + cityId + '">' + cityName + '</option>';
        }
        $('#selectCity{{ $for or "" }}').html(cityOptionHtml);
    }

    $(function () {
        // changeProvince{{$for or ''}}();
    });
</script>