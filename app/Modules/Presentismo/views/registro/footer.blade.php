<tfoot>
<tr>
    <th></th>
    <th></th>
    <th></th>
    <th></th>
    @for($i = 0; $i < count($fechasToShow) ;$i++)
        <th>@lang('day.'.$fechasToShow[$i]['day'])</th>
    @endfor
</tr>
</tfoot>
