{{-- custom return value via attribute --}}
<td>
	<?php
    echo $entry->{$column['relation']}()->{$column['relation_attribute']};
    ?>
</td>