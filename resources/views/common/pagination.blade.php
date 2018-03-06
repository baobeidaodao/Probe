<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: pagination.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-12 07:38:00
 */

$show = isset($show) ? $show : 3;
$page = $page > 0 ? $page : 1;
$count = $count > 0 ? $count : 1;
?>

<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
        {{-- first --}}
        <li class="page-item">
            <a class="page-link" href="{{ $url . 1 }}" data-page="1"><<</a>
        </li>
        {{-- prev --}}
        @if( $page == 1)
            <li class="page-item">
                <a class="page-link" href="{{ $url . $page }}" data-page="{{ $page or 0 }}"><</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $url . ($page - 1) }}" data-page="{{ ($page - 1) }}"><</a>
            </li>
        @endif
        {{-- min--}}
        @if($page - $show -1 > 0)
            <li class="page-item">
                <a class="page-link" href="{{ $url . 1}}" data-page="{{ 1 }}">1</a>
            </li>
        @endif
        {{-- earlier --}}
        @if($page - $show  -1 > 1 )
            <li class="page-item">
                <a class="page-link">...</a>
            </li>
        @endif
        {{-- before--}}
        @for ($i = $show; $i > 0; $i--)
            @if($page -$i > 0)
                <li class="page-item">
                    <a class="page-link" href="{{ $url . ($page - $i) }}" data-page="{{ ($page - $i) }}">{{ ($page - $i) }}</a>
                </li>
            @endif
        @endfor
        {{-- current --}}
        <li class="page-item active">
            <a class="page-link" href="{{ $url . $page }}" class="ahover" data-page="{{ $page }}">{{ $page }}</a>
        </li>
        {{-- after --}}
        @for ($i = 1; $i <= $show && $page + $i <= $count; $i++)
            <li class="page-item">
                <a class="page-link" href="{{$url . ($page + $i) }}" data-page="{{ ($page + $i) }}">{{ ($page + $i) }}</a>
            </li>
        @endfor
        {{-- later --}}
        @if($count - ($page + $show) > 1)
            <li class="page-item">
                <a class="page-link">...</a>
            </li>
        @endif
        {{-- max --}}
        @if($count - ($page + $show) > 0)
            <li class="page-item">
                <a class="page-link" href="{{ $url . $count }}" data-page="{{ $count }}">{{ $count }}</a>
            </li>
        @endif
        {{-- next --}}
        @if($page == $count)
            <li class="page-item">
                <a class="page-link" href="{{$url . $page }}" data-page="{{ $page }}">></a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $url . ($page + 1)}}" data-page="{{ ($page + 1) }}">></a>
            </li>
        @endif
        {{-- last --}}
        <li class="page-item">
            <a class="page-link" href="{{ $url . $count }}" data-page="{{ $count }}">>></a>
        </li>
    </ul>
</nav>
<input id="searchFormPage" type="hidden" name="page" value="{{ $page or 1 }}">
<script>
    var type = "{{ $type or '' }}";
    if (type === 'search') {
        $("#searchButton").click(function () {
            $("#searchFormPage").val(1);
        });
        $(".page-link").click(function () {
            var page = $(this).attr('data-page');
            if (typeof(page) === 'undefined') {
                return false;
            }
            $("#searchFormPage").val(page);
            $("#searchForm").submit();
            return false;
        });
    }
</script>