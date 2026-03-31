<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Base;
use Cat\Models\TipoContrato;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * Return the fully qualified model class name.
     */
    abstract public function model(): string;

    /**
     * Resolve a new instance of the model.
     */
    protected function makeModel(): Model
    {
        return app($this->model());
    }

    /**
     * Get all records.
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*'])
    {
        return $this->makeModel()->newQuery()->get($columns);
    }

    /**
     * Create a new record.
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->makeModel()->newQuery()->create($attributes);
    }

    /**
     * Update a record by id.
     *
     * @param array $attributes
     * @param int $id
     * @return Model
     */
    public function update(array $attributes, $id)
    {
        $model = $this->makeModel()->newQuery()->findOrFail($id);
        $model->update($attributes);

        return $model;
    }

    /**
     * Delete a record by id.
     *
     * @param int $id
     * @return bool|null
     */
    public function delete($id)
    {
        return $this->makeModel()->newQuery()->findOrFail($id)->delete();
    }

    /**
     * Find a record by id, returning null on failure.
     *
     * @param int $id
     * @param array $columns
     * @return Model|null
     */
    public function findWithoutFail($id, array $columns = ['*'])
    {
        return $this->makeModel()->newQuery()->find($id, $columns);
    }

    /**
     * Find a record by id.
     *
     * @param int $id
     * @param array $columns
     * @return Model
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->makeModel()->newQuery()->findOrFail($id, $columns);
    }

    /**
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_bases', fn() => Base::all());
        } else {
            $bases = Base::all();
        }

        return $bases;
    }


    public static function getOnlyForLocacion()
    {
        /** @var \Illuminate\Database\Query\Builder $eloq */
        $eloq = Base::select(['bases.id', 'bases.nombre']);

        $eloq
            ->distinct()
            ->join('operativos', 'bases.id', '=', 'operativos.id_base')
            ->join('agentes', 'agentes.id', '=', 'operativos.id_agente')
            ->join('contratos', function ($joinClause): void {
                /** @var \Illuminate\Support\Collection $tipo */
                /** @var \Illuminate\Database\Query\JoinClause $joinClause */

                $tipo = TipoContrato::select('id')
                    ->where('codigo', 'LOCACION')
                    ->get();

                $joinClause->on('agentes.id', '=', 'contratos.id_agente')
                    ->whereIn('id_tipo_contrato', array_keys($tipo->keyBy('id')->toArray()));
            });

        return $eloq;
    }
}
