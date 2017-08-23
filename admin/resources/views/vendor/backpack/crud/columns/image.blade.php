@php
$width = isset($column['width']) ? $column['width'].'px' : '50px';
$height = isset($column['height']) ? $column['height'].'px' : '50px';
@endphp
<td class="crud-image-column">
    @if($entry->{$column['name']})
        <div style="width:{{$width}};height:{{$height}};background:url({{ url($entry->{$column['name']}) }}) 50% 50% no-repeat;background-size:cover;"></div>
    @else
        <div style="width:{{$width}};height:{{$height}};background:#ddd;"></div>
    @endif
</td>

