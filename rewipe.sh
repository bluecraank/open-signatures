php artisan db:wipe && php artisan migrate && php artisan db:seed PermissionSeeder && php artisan db:seed LdapAttributeSeeder

read -p "Make first user admin? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    php artisan app:make-first-user-admin
fi
