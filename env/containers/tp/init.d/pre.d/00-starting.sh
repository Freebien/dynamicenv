echo "$(date) - [INFO] launching for pre init"

if [ ! -z "${FLAG1_FILE}" ]; then
    FLAG1=$(cat "${FLAG1_FILE}")
fi
if [ ! -z "${FLAG2_FILE}" ]; then
    FLAG2=$(cat "${FLAG2_FILE}")
fi
if [ ! -z "${FLAG3_FILE}" ]; then
    FLAG3=$(cat "${FLAG3_FILE}")
fi
