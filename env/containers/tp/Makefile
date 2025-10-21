include .env
# FLAG1=ThisIsACoolPassw0rd!!!!;)
# FLAG2=ThisIsAFreakPass
# FLAG3=HolyGrailThisPass!

REPO=opsie
IMAGE=tp
TAG=1

all: build

build:
	docker build -t ${REPO}/${IMAGE}:${TAG} --build-arg "FLAG1=${FLAG1}" --build-arg "FLAG2=${FLAG2}" --build-arg "FLAG3=${FLAG3}" .
