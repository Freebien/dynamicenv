sbadminpassword="$(cat /etc/sbadmin/sbadmin.passwd)"
pushd /var/www/html >/dev/null 2>&1
php init.php "${sbadminpassword}"
rm init.php index.html
popd >/dev/null 2>&1
