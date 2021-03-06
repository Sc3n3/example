<?php

namespace App\RealEstate\Models\Traits;

use Illuminate\Database\Query\Builder;

trait DefaultAble
{
    /**
     * @param Builder $query
     * @param bool $value
     * @return Builder
     */
    public function scopeDefault(Builder $query, bool $value = true)
    {
        return $query->where('default', $value);
    }

    /**
     * @param bool $default
     * @return $this
     */
    public function setDefault(bool $default = true)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return (bool) $this->default;
    }
}