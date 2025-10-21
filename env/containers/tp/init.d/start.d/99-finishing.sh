echo "$(date) - [INFO] finishing for start init"
mkdir -p /var/log/apache2
tail -f /var/log/apache2/access.log /var/log/apache2/error.log
