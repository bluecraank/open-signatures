<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ADUser extends Model
{
    protected $table = 'ad_users';

    protected $fillable = [
        'name',
        'username',
        'guid',
        'distinguishedname',
    ];

    public function getGroupNamesAttribute()
    {
        return $this->groups->pluck('name');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'aduser_group', 'aduser_id', 'group_id');
    }
}
