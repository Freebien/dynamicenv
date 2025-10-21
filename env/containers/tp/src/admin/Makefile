BUILD_DIR=build

all: prepare build

prepare:
	mkdir -p ${BUILD_DIR}

build: admin rop

admin:
	gcc -m32 admin.c -z execstack -fno-stack-protector -o ${BUILD_DIR}/admin

rop:
	gcc -static -m32 -fno-stack-protector admin.c -o ${BUILD_DIR}/admin_rop
