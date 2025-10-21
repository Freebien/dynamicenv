license="${FLAG1:=}"
if [ -z "${license}" ]; then
    license="$(openssl rand -base64 32)"
fi
echo "${license}" > /etc/sbadmin/license.key
chown root:root /etc/sbadmin/license.key
chmod 400 /etc/sbadmin/license.key
