#!/bin/bash -eu

USERNAME="${USERNAME:-student}"
PASSWORD="${USERNAME:-student}"
USERNAME_FILE=""
PASSWORD_FILE=""
env

if [ ! -z "${USERNAME_FILE}" ]; then
	USERNAME=$(cat ${USERNAME_FILE})
fi
if [ ! -z "${PASSWORD_FILE}" ]; then
	PASSWORD=$(cat ${PASSWORD_FILE})
fi

echo "checking user"

if ! getent passwd ${USERNAME}; then
	echo creating user
	useradd -m "${USERNAME}"
	usermod -aG sudo "${USERNAME}"
	echo "${USERNAME}:${PASSWORD}" | chpasswd
fi

echo launching sshd
ssh-keygen -A
/usr/sbin/sshd -D
