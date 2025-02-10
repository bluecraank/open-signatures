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

    public function adgroups()
    {
        return $this->belongsToMany(ADGroup::class, 'aduser_adgroup', 'aduser_id', 'adgroup_id');
    }

    public function assignedGroupsByAny()
    {
        return Group::where('any_user', true)->get();
    }

    public function getAssignedTemplates() {
        $anyAssignedGroups = $this->assignedGroupsByAny();
        foreach ($anyAssignedGroups as $group) {
            $templateList[] = $group->template_id;
        }

        $directAssignedGroups = $this->groups;
        foreach ($directAssignedGroups as $group) {
            $templateList[] = $group->template_id;
        }

        $assignedADGroups = $this->adgroups;
        foreach ($assignedADGroups as $group) {
            $localGroups = $group->groups;
            foreach ($localGroups as $localGroup) {
                $templateList[] = $localGroup->template_id;
            }
        }

        // Remove duplicates
        $templateList = array_unique($templateList);

        return $templateList;
    }
}
