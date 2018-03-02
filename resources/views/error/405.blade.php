<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title>页面不存在 - 亿邦动力网</title>
<link href="{{config('app.imgs_url')}}/style/2013/404.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{config('app.imgs_url')}}/js/jquery.min.1.9.1.js"></script>
<style type="text/css">
	.e404_box{width:600px;background:url({{config('app.imgs_url')}}/images/404/e404_bg01.gif) no-repeat;margin:0 auto;}
	.e404_head{padding:201px 0 0 54px;}
	.e404_head span{background:url({{config('app.imgs_url')}}/images/404/e404_name.gif);width:102px;height:25px;display:block;margin-left:-6px;}
	.e404_rehome{background:url({{config('app.imgs_url')}}/images/404/e404_bg02.gif);width:239px;height:72px;display:block;margin:-53px 0 0 408px;}
</style>
</head>
<body>
<div class="e404_box">
	<p class="e404_head"><img src="{{config('app.imgs_url')}}/images/404/erye.gif" width="105" height="105" /><span></span></p>
    <a href="{{config('app.www_url')}}" class="e404_rehome"></a>
    <div align="right">
        Status_Code:{{$status_code}}
    </div>
</div>
<script type="text/javascript">
	$(".e404_box").css("marginTop",($(window).height()-parseInt($(".e404_box").css("height")))/2)
</script>
</body>
</html>