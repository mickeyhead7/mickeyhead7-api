<?php

namespace Mickeyhead7\Api\Database;

trait ActiveTrait
{

    /**
     * Apply scope to all queries
     */
    public static function bootActiveTrait()
    {
        static::addGlobalScope(new ActiveScope);
    }

    /**
     * Get the active column
     *
     * @return string
     */
    public function getActiveColumn()
    {
        return defined('static::ACTIVE_COLUMN') ? static::ACTIVE_COLUMN : 'active';
    }

    /**
     * Get the qualified active column
     *
     * @return string
     */
    public function getQualifiedActiveColumn()
    {
        return $this->getTable().'.'.$this->getActiveColumn();
    }

    /**
     * Provide a method to get results with any active state
     *
     * @return mixed
     */
    public static function withDrafts()
    {
        return with(new static)->newQueryWithoutScope(new ActiveScope);
    }

}
