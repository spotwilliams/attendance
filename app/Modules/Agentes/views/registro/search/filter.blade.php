<h4>Filtrar por</h4>
<div class="btn-group">
    <button type="button"
            class="btn btn-primary dropdown-toggle"
            data-toggle="dropdown"
            aria-expanded="false"
    >Bases
        <span class="fa fa-caret-down"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php $bases = \Cat\Repositories\BaseRepository::getAll() ?>
        @foreach($bases as $b)
            <li><a href="?base={{ $b->id }}">{{$b->nombre}}</a></li>
        @endforeach
    </ul>
</div>

