<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Schedule extends Model
{
    protected static function booted(): void
    {
        static::created(function (Schedule $schedule) {
            $ip = request()->ip();

            // If HTTP_X_FORWARDED_FOR is set, use that instead
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            Log::create([
                'ip_address' => $ip,
                'username' => Auth::user()->name,
                'action' => __('log.schedule_created', ['name' => $schedule->name]),
            ]);
        });

        static::updated(function (Schedule $schedule) {
            $ip = request()->ip();

            // If HTTP_X_FORWARDED_FOR is set, use that instead
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            Log::create([
                'ip_address' => $ip,
                'username' => Auth::user()->name ?? 'System',
                'action' => __('log.schedule_updated', ['name' => $schedule->name]),
            ]);
        });

        static::deleted(function (Schedule $schedule) {
            $ip = request()->ip();

            // If HTTP_X_FORWARDED_FOR is set, use that instead
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }

            Log::create([
                'ip_address' => $ip,
                'username' => Auth::user()->name,
                'action' => __('log.schedule_deleted', ['name' => $schedule->name]),
            ]);
        });
    }

    protected $fillable = [
        'name',
        'template_id',
        'ldap_groups',
        'ldap_users',
        'start_time',
        'end_time',
        'enabled',
        'created_by',
        'delete_presentation',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'ldap_groups' => 'array',
        'ldap_devices' => 'array',
    ];

    public function casts(): array
    {
        return $this->casts;
    }

    public function groups()
    {
        $groups = collect();
        return 0;
    }

    public function appliesTo()
    {
        $groups = $this->groups();
        $devices = $this->devices();
        return $devices->count() . ' ' . trans_choice('Device|Devices', $devices->count()) . ', ' . $groups->count() . ' ' . trans_choice('Group|Groups', $groups->count());
    }

    public function templates()
    {
        return $this->belongsTo(Template::class);
    }

    public function startDate()
    {
        $locale = config('app.locale');
        if ($locale == 'de') {
            return Carbon::parse($this->start_time)->format('d.m.Y H:i');
        }

        return Carbon::parse($this->start_time)->format('Y-m-d H:i');
    }

    public function endDate()
    {
        $locale = config('app.locale');
        if ($locale == 'de') {
            return Carbon::parse($this->end_time)->format('d.m.Y H:i');
        }

        return Carbon::parse($this->end_time)->format('Y-m-d H:i');
    }
}
