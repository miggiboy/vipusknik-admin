<?php

namespace App\Models\User;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     * The model is mass assignable (but they shouldn't be)
     *
     * @var array
     */
    protected $guarded = [];
}
