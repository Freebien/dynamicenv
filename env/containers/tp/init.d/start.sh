#!/bin/bash -eum

dir=$(dirname $0)

if [ -d "${dir}/pre.d" ]; then
    echo "$(date) - [INFO] launching pre scripts"
    for s in ${dir}/pre.d/[0-9][0-9]*; do
	echo $s
        . ${s}
    done
fi

if [ -d "${dir}/start.d" ]; then
    echo "$(date) - [INFO] launching start scripts"
    for s in ${dir}/start.d/[0-9][0-9]*; do
        . ${s}
    done
fi

if [ -d "${dir}/post.d" ]; then
    echo "$(date) - [INFO] launching post scripts"
    for s in ${dir}/post.d/[0-9][0-9]*; do
        . ${s}
    done
fi

echo "$(date) - [INFO] exiting"
