<?php

namespace Mickeyhead7\Api\Database;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\ScopeInterface;
use \Illuminate\Database\Query\Builder as BaseBuilder;

class PublishedScope implements ScopeInterface
{

    /**
     * Apply the scope
     *
     * @param Builder $builder
     */
    public function apply(Builder $builder, Model $model)
    {
        $column = $builder->getModel()->getQualifiedPublishedColumn();
        $builder->where($column, '=', 1);
        $this->addWithDrafts($builder);
    }

    /**
     * Remove the scope
     *
     * @param Builder $builder
     */
    public function remove(Builder $builder)
    {
        $query = $builder->getQuery();
        $column = $builder->getModel()->getQualifiedPublishedColumn();
        $bindingKey = 0;

        foreach ((array) $query->wheres as $key => $where)
        {
            if ($this->isPublishedConstraint($where, $column))
            {
                $this->removeWhere($query, $key);
                $this->removeBinding($query, $bindingKey);
            }

            if ( ! in_array($where['type'], ['Null', 'NotNull'])) $bindingKey++;
        }
    }

    /**
     * Remove the scope where necessary
     *
     * @param BaseBuilder $query
     * @param $key
     */
    protected function removeWhere(BaseBuilder $query, $key)
    {
        unset($query->wheres[$key]);
        $query->wheres = array_values($query->wheres);
    }

    /**
     * Remove the scope binding
     *
     * @param BaseBuilder $query
     * @param $key
     */
    protected function removeBinding(BaseBuilder $query, $key)
    {
        $bindings = $query->getRawBindings()['where'];
        unset($bindings[$key]);
        $query->setBindings($bindings);
    }

    /**
     * Check if given where is the scope constraint
     *
     * @param array $where
     * @param $column
     * @return bool
     */
    protected function isPublishedConstraint(array $where, $column)
    {
        return ($where['type'] == 'Basic' && $where['column'] == $column && $where['value'] == 1);
    }

    /**
     * Extend the builder with the custom method
     *
     * @param Builder $builder
     */
    protected function addWithDrafts(Builder $builder)
    {
        $builder->macro('withDrafts', function(Builder $builder)
        {
            $this->remove($builder);

            return $builder;
        });
    }

}
