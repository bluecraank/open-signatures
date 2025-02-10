<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ADGroup extends Model
{
    protected $table = 'ad_groups';

    protected $fillable = [
        'name',
        'guid',
        'distinguishedname',
    ];

    public function users()
    {
        return $this->belongsToMany(ADUser::class, 'aduser_adgroup', 'adgroup_id', 'aduser_id');
    }

    public function getUserNamesAttribute()
    {
        return $this->users->pluck('name');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'adgroup_group', 'adgroup_id', 'group_id');
    }

    public function assignedGroupsByAny()
    {
        return Group::where('any_group', true)->get();
    }
}
