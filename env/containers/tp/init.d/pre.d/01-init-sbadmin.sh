mkdir -p /etc/sbadmin

sbadminpassword="${FLAG2:=}"
env
echo $sbadminpassword

if [ -z "${sbadminpassword}" ]; then
    sbadminpassword="$(openssl rand -base64 32)"
fi
echo "${sbadminpassword}" > /etc/sbadmin/sbadmin.passwd
chown sbadmin /etc/sbadmin/sbadmin.passwd
chmod 400 /etc/sbadmin/sbadmin.passwd
echo "sbadmin:${sbadminpassword}" | chpasswd

adminpassword="${FLAG3:=}"
if [ -z "${adminpassword}" ]; then
    adminpassword="$(openssl rand -base64 32)"
fi
echo "${adminpassword}" > /etc/sbadmin/admin.passwd
chown admin /etc/sbadmin/admin.passwd
chmod 400 /etc/sbadmin/admin.passwd
echo "admin:${adminpassword}" | chpasswd

admin_panel_password="${FLAG4:=}"
if [ -z "${admin_panel_password}" ]; then
    admin_panel_password="$(openssl rand -base64 32)"
fi
echo "${admin_panel_password}" > /etc/sbadmin/admin_panel.passwd
chown root /etc/sbadmin/admin_panel.passwd
chmod 400 /etc/sbadmin/admin_panel.passwd
echo "root:${admin_panel_password}" | chpasswd
