<?php

namespace Mickeyhead7\Api\Database;

trait PublishedTrait
{

    /**
     * Apply scope to all queries
     */
    public static function bootPublishedTrait()
    {
        static::addGlobalScope(new PublishedScope);
    }

    /**
     * Get the published column
     *
     * @return string
     */
    public function getPublishedColumn()
    {
        return defined('static::PUBLISHED_COLUMN') ? static::PUBLISHED_COLUMN : 'published';
    }

    /**
     * Get the qualified published column
     *
     * @return string
     */
    public function getQualifiedPublishedColumn()
    {
        return $this->getTable().'.'.$this->getPublishedColumn();
    }

    /**
     * Provide a method to get results with any published state
     *
     * @return mixed
     */
    public static function withDrafts()
    {
        return with(new static)->newQueryWithoutScope(new PublishedScope);
    }

}
