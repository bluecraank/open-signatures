<?php

namespace App\Http\Controllers;

use App\Models\ADUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LdapAttributeController extends Controller
{
    public static function getLdapGroups() {
        $groups = \LdapRecord\Models\ActiveDirectory\Group::in('OU=Gruppen,DC=Doepke,DC=local')->get();

        $exclude_groups = env('LDAP_EXCLUDE_GROUP_OUs', '');
        $exclude_groups = explode(',', $exclude_groups);

        // TODO: Filter out groups via gui options

        foreach ($exclude_groups as $exclude_group) {
            $groups = $groups->filter(function ($group) use ($exclude_group) {
                return !str_contains($group->distinguishedname[0], "OU=".$exclude_group);
            });
        }

        return $groups;
    }

    public static function getLdapUsers() {
        return \LdapRecord\Models\ActiveDirectory\User::in('OU=Benutzer,DC=Doepke,DC=local')->get();
    }
}
