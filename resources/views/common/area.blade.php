<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: area.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 09:02:00
 */
$area_id = isset($area_id) ? $area_id : 0;
$areaMap = isset($areaMap) ? $areaMap : [];
$areaMapJson = json_encode($areaMap);
$province_id = 0;
$city_id = 0;
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
</script>
<div class="form-row align-items-center">
    <div class="col-auto">
        <label class="sr-only" for="selectProvince">Province</label>
        <div class="form-group mb-2">
            <select name="province_id" id="selectProvince" class="form-control" onchange="changeProvince();" @if(isset($readonly) && $readonly == true) readonly @endif >
                <option value="">Province</option>
                @foreach($areaMap as $province)
                    <option value="{{ $province['id'] }}" @if($province['id'] == $province_id) selected @endif >{{ $province['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="selectCity">City</label>
        <div class="form-group mb-2">
            <select name="city_id" class="form-control" id="selectCity" @if(isset($readonly) && $readonly == true) readonly @endif >
                <option value="">City</option>
                @foreach($areaMap as $province)
                    @foreach($province['sub_area'] as $city)
                        <option value="{{ $city['id'] }}" @if($city['id'] == $city_id) selected @endif >{{ $city['name'] }}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </div>
</div>
<script>
    function changeProvince() {
        var selectedOption = $("#selectProvince").find(":selected");
        var provinceId = selectedOption.attr('value');
        changeCity(provinceId);
    }

    function changeCity(provinceId) {
        var cityList;
        for (var i = 0, l = areaMap.length; i < l; i++) {
            if (parseInt(provinceId) === parseInt(areaMap[i]['id'])) {
                cityList = areaMap[i]['sub_area'];
            }
        }
        setCity(cityList);
    }

    function setCity(cityList) {
        var cityOptionHtml = '';
        cityOptionHtml += '<option value="">City</option>';
        var cityId;
        var cityName;
        for (var i = 0, l = cityList.length; i < l; i++) {
            cityId = cityList[i]['id'];
            cityName = cityList[i]['name'];
            cityOptionHtml += '<option value="' + cityId + '">' + cityName + '</option>';
        }
        $("#selectCity").html(cityOptionHtml);
    }
</script>