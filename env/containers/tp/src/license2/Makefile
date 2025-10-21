BUILD_DIR=build

all: prepare build

prepare:
	mkdir -p ${BUILD_DIR}

build: license

license:
	gcc -m32 license.c -o ${BUILD_DIR}/license

