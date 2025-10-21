#!/bin/bash -eu

. "$(dirname $0)/scripts/generate_secret.sh"

if [ $# -lt 3 ]; then
	echo "usage: $0 <up|down|scale> group [num...]"
	exit 1
fi

export CMD=$1
shift
if [ "${CMD}" != "up" ] && [ "${CMD}" != "down" ] && [ "${CMD}" != "scale" ]; then
	echo "usage: $0 <up|down> group [num...]"
	exit 1
fi

export GROUP=$1
shift

mkdir -p "$(dirname $0)/data/${GROUP}"

if [ "${CMD}" == "scale" ]; then
	export SVC=$1
	echo "service: ${SVC}"
	shift
fi

SECRETS=("postgres_password=16" "box_db_password=16" "box_admin_password=16" "box_bob_password=16" "flag1=23" "flag2=23" "flag3=23")

prepare() {
    secret_dir="$(dirname $0)/data/${GROUP}/${1}/secrets"
    data_dir="$(dirname $0)/data/${GROUP}/${1}/shell-data"
    if [ ! -d "${secret_dir}" ]; then
        mkdir -p "${secret_dir}"
    fi
    if [ ! -d "${data_dir}" ]; then
        mkdir -p "${data_dir}"
    fi
    for key in ${SECRETS[@]}; do
        count=${key##*=}
        name=${key%%=*}
        if [ ! -f "${secret_dir}/${name}" ]; then
            generateSecret "${count}" > "${secret_dir}/${name}"
        fi
    done
}


up() {
	NUM=$1 docker stack deploy -c docker-compose.yml --with-registry-auth env-${GROUP}-$1
}

down() {
	docker stack rm env-${GROUP}-$1
}

scale() {
	docker service scale -d env-${GROUP}-${1}_${SVC}=0
	docker service scale -d env-${GROUP}-${1}_${SVC}=1
}

for i in ${@}; do
    prepare $i
done

echo ${@} | xargs -n 1 | xargs -P4 -I@  bash -c "$(declare -f ${CMD}); ${CMD} @"