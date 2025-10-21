echo "$(date) - [INFO] - starting sshd"
ssh-keygen -A
mkdir /run/sshd

/usr/sbin/sshd &