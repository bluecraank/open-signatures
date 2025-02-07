<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = ['name', 'html_content', 'plain_text_content', 'created_by'];


    public function users()
    {
        return $this->belongsToMany(ADUser::class, 'aduser_user', 'user_id', 'aduser_id');
    }

    public function groups()
    {
        return $this->belongsToMany(ADGroup::class, 'adgroup_group', 'group_id', 'adgroup_id');
    }

    public function localGroups()
    {
        return Group::where('template_id', $this->id)->get();
    }
    public function groupList()
    {
        return $this->localGroups()->pluck('name')->implode(', ');
    }

}
