<?php

namespace App\Console\Commands;

use App\Http\Controllers\LdapAttributeController;
use App\Models\ADGroup;
use App\Models\ADUser;
use App\Models\LdapAttribute;
use Illuminate\Console\Command;

class QueryADGroupsAndUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:query-ad-groups-and-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Query AD groups and users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $groups = LdapAttributeController::getLdapGroups();
        $users = LdapAttributeController::getLdapUsers();


        foreach ($groups as $group) {
            $guid = $group->objectguid[0];
            // guid is binary, convert to string
            $guid = bin2hex($guid);

            ADGroup::updateOrCreate(
                ['guid' => $guid],
                ['distinguishedname' => $group->distinguishedname[0], 'name' => $group->name[0]]
            );
        }

        foreach ($users as $user) {
            $guid = $user->objectguid[0];
            // guid is binary, convert to string
            $guid = bin2hex($guid);

            ADUser::updateOrCreate(
                ['guid' => $guid],
                ['distinguishedname' => $user->distinguishedname[0], 'name' => $user->name[0], 'username' => $user->samaccountname[0]]
            );
        }

        // Assign users to groups

        $adusers = ADUser::all();

        foreach ($users as $user) {
            if (!isset($user->memberof)) {
                continue;
            }
            foreach($user->memberof as $group) {
                $aduser = ADUser::where('distinguishedname', $user->distinguishedname[0])->first();
                $group = ADGroup::where('distinguishedname', $group)->first();
                if ($group) {
                    $group->users()->syncWithoutDetaching($aduser->id);
                }
            }
        }
    }
}
