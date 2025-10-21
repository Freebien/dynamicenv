echo "$(date) - [INFO] finishing for post init"

unset FLAG1
unset FLAG2
unset FLAG3
if [ ! -z "${FLAG1_FILE}" ]; then
	rm "${FLAG1_FILE}"
fi
unset FLAG1_FILE
if [ ! -z "${FLAG2_FILE}" ]; then
	rm "${FLAG2_FILE}"
fi
unset FLAG2_FILE
if [ ! -z "${FLAG3_FILE}" ]; then
	rm "${FLAG3_FILE}"
fi
unset FLAG3_FILE
