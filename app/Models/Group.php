<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected static function booted(): void
    {
        static::created(function (Group $group) {

            $ip = request()->ip();
            // If HTTP_X_FORWARDED_FOR is set, use that instead
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            Log::create([
                'ip_address' => $ip,
                'username' => Auth::user()->name ?? 'System',
                'action' => __('log.group_created', ['name' => $group->name]),
            ]);
        });

        static::deleted(function (Group $group) {

            $ip = request()->ip();
            // If HTTP_X_FORWARDED_FOR is set, use that instead
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            Log::create([
                'ip_address' => $ip,
                'username' => Auth::user()->name ?? 'System',
                'action' => __('log.group_deleted', ['name' => $group->name]),
            ]);
        });
    }

    protected $fillable = ['name', 'template_id', 'created_by', 'any_user', 'any_group'];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function users()
    {
        return $this->belongsToMany(ADUser::class, 'aduser_group', 'group_id', 'aduser_id');
    }

    public function groups()
    {
        return $this->belongsToMany(ADGroup::class, 'adgroup_group', 'group_id', 'adgroup_id');
    }
}
