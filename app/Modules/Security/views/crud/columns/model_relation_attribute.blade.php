{{-- custom return value via attribute --}}
<td>
    <?php
    $attributes = (is_array($column['attribute']) ? $column['attribute'] : [$column['attribute']]);
    foreach ($attributes as $attr)
        echo $entry->{$column['entity']}->{$attr};
    ?>
</td>