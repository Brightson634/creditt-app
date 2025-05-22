<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (app()->bound('tenant')) {
            $tenant = app('tenant');
            $builder->where('tenant_id', $tenant->id);
        }
    }
}
