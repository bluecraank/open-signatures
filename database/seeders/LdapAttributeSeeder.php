<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LdapAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $vars = [
            'surname' => 'givenName',
            'lastname' => 'sn',
            'email' => 'mail',
            'mobile' => 'mobile',
            'telephone' => 'telephoneNumber',
            'department' => 'department',
            'company' => 'company',
            'title' => 'title',
            'position' => 'title',
            'city' => 'l',
            'country' => 'co',
            'zip' => 'postalCode',
        ];

        foreach ($vars as $variable_name => $ldap_attribute) {
            \App\Models\LdapAttribute::updateOrCreate(['variable_name' => $variable_name, 'name' => $ldap_attribute]);
        }
    }
}
