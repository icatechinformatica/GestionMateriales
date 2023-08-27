<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * un trait
 */
trait Searchable
{
    /**
     * Scope a query to search for term in the attributes
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
    */

    protected function scopeSearch($query)
    {
        # lógica de busqueda
        [$searchTerm, $attributes] = $this->parseArguments(func_get_args());

        if (!$searchTerm || !$attributes) {
            # retornamos la consulta si no hay atributos o termino de la consulta
            return $query;
        }

        return $query->where(function(Builder $query) use ($searchTerm, $attributes){
            foreach (Arr::wrap($attributes) as $attribute) {
                # entramos en un loop
                $query->when(
                    str_contains($attribute, '.'),
                    function (Builder $query) use ($searchTerm, $attribute){
                        [$relationName, $relationAttribute] = explode('.', $attribute);

                        $query->orWhereHas($relationName, function (Builder $query) use ($searchTerm, $relationAttribute){
                            $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                        });
                    },
                    function (Builder $query) use ($searchTerm, $attribute) {
                        $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                    }
                );
            }
        });
    }

     /**
     * Parse search scope arguments
     *
     * @param array $arguments
     * @return array
    */

    private function parseArguments(array $arguments)
    {
        // analizando ...
        $args_count = count($arguments);

        switch ($args_count) {
            case 1:
                # retornamos
                return [request(config('searchable.key')), $this->searchableAttributes()];
                break;

            case 2:
                # retornamos
                return is_string($arguments[1])
                    ? [$arguments[1], $this->searchableAttributes()]
                    : [request(config('searchable.key')), $arguments[1]];
                break;

            case 3:
                # retornamos
                return is_string($arguments[1])
                    ? [$arguments[1], $arguments[2]]
                    : [$arguments[2], $arguments[1]];
                break;
            default:
                # retornamos por defecto
                return [null, []];
                break;
        }

    }

    /**
     * Get searchable columns
     *
     * @return array
    */

    public function searchableAttributes(){
        if (method_exists($this, 'searchable')) {
            # regresamos el método
            return $this->searchable();
        }

        return property_exists($this, 'searchable') ? $this->searchable : [];
    }
}
