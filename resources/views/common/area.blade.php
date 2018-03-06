<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: area.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-24 09:02:00
 */
$for = isset($for) ? $for : '';
$areaMap = isset($areaMap) ? $areaMap : [];
$areaMapJson = json_encode($areaMap);
$departmentList = isset($departmentList) ? $departmentList : [];
$departmentListJson = json_encode($departmentList);
if (isset($area_id) && !empty($area_id)) {
    $area_id = isset($area_id) ? $area_id : 0;
    $province_id = 0;
    $city_id = 0;
    $area_level = 0;
    foreach ($areaMap as $province) {
        if ($province['id'] == $area_id) {
            $area_level = $province['level'];
            $province_id = $area_id;
            break;
        } else if (isset($province['sub_area']) && !empty($province['sub_area'])) {
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
} else {
    $province_id = isset($province_id) ? $province_id : 0;
    if (isset($city_id) && !empty($city_id)) {
        $area_level = 2;
        $city_id = isset($city_id) ? $city_id : 0;
    } else {
        $area_level = 1;
        $city_id = isset($city_id) ? $city_id : 0;
    }
}
if (count($areaMap) == 1) {
    $province_id = $areaMap[0]['id'];
    if (count($areaMap[0]['sub_area']) == 1) {
        $city_id = $areaMap[0]['sub_area'][0]['id'];
    }
}
?>
<script>
    var areaMapJson = '<?php echo $areaMapJson; ?>';
    var areaMap = JSON.parse(areaMapJson);
    var departmentListJson = '<?php echo $departmentListJson; ?>';
    var departmentList = JSON.parse(departmentListJson);
    var areaId = '<?php echo $area_id; ?>';
    var areaLevel = '<?php echo $area_level; ?>';
</script>
<div class="form-row align-items-center {{ $class or '' }}">
    <div class="col-auto">
        <label class="sr-only" for="selectProvince{{ $for or '' }}">省</label>
        <div class="form-group mb-2">
            <select name="province_id" id="selectProvince{{ $for or '' }}" class="form-control" onchange="changeProvince{{$for or ''}}();" @if(isset($readonly) && $readonly == true) readonly @endif >
                @if(count($areaMap)>1)
                    <option value="">省</option>
                @endif
                @foreach($areaMap as $province)
                    @if(isset($province['level']) && $province['level'] == \App\Models\Area::LEVEL_PROVINCE)
                        <option value="{{ $province['id'] }}" @if($province['id'] == $province_id) selected @endif >{{ $province['name'] or '' }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-auto">
        <label class="sr-only" for="selectCity{{ $for or '' }}">市<?php echo($province_id);?>  </label>
        <div class="form-group mb-2">
            <select name="city_id" class="form-control" id="selectCity{{ $for or '' }}" onchange="changeDepartment{{ $for or '' }}();" @if(isset($readonly) && $readonly == true) readonly @endif >
                @if((count($areaMap)>1) || (count($areaMap)==1 && count($areaMap[0]['sub_area'])>1))
                    <option value="">市</option>
                @endif
                @foreach($areaMap as $province)
                    @if($province['id'] == $province_id && isset($province['sub_area']) && !empty($province['sub_area']))
                        @foreach($province['sub_area'] as $city)
                            <option value="{{ $city['id'] }}" @if($city['id'] == $city_id) selected @endif >{{ $city['name'] or '' }}</option>
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
        cityOptionHtml += '<option value="">市</option>';
        var cityId;
        var cityName;
        for (var i = 0, l = cityList.length; i < l; i++) {
            cityId = cityList[i]['id'];
            cityName = cityList[i]['name'];
            cityOptionHtml += '<option value="' + cityId + '">' + cityName + '</option>';
        }
        $('#selectCity{{ $for or "" }}').html(cityOptionHtml);
    }

    function changeDepartment{{ $for or "" }}() {
        var selectedOption = $('#selectCity{{ $for or "" }}').find(":selected");
        var cityId = selectedOption.attr('value');
        var selectDepartment = $('#selectDepartment{{ $for or "" }}');
        if (typeof(selectDepartment) === 'undefined') {
            return false;
        }
        var departmentOptionHtml = '';
        // departmentOptionHtml += '<option value="">选择</option>';
        var departmentId;
        var departmentName;
        var departmentAreaId;
        var count = 0;
        for (var i = 0, l = departmentList.length; i < l; i++) {
            departmentId = departmentList[i]['id'];
            departmentName = departmentList[i]['name'];
            departmentAreaId = departmentList[i]['area_id'];
            if (parseInt(cityId) === parseInt(departmentAreaId)) {
                departmentOptionHtml += '<option value="' + departmentId + '">' + departmentName + '</option>';
                count = count + 1;
            }
        }
        if (count !== 1) {
            departmentOptionHtml = '<option value="">选择</option>' + departmentOptionHtml;
        }
        $('#selectDepartment{{ $for or "" }}').html(departmentOptionHtml);
    }

    $(function () {
        // changeProvince{{$for or ''}}();
    });
</script>