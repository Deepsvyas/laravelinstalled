<?php

namespace App\Models\User\Traits;

trait UserRelationShips {

    /**
     * role() one-to-one relationship method
     * 
     * @return QueryBuilder
     */
    public function role() {
        return $this->belongsTo('App\Models\Role', 'role_id', 'role_id');
    }

}
