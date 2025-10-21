BUILD_DIR=build

all: prepare build

prepare:
	mkdir -p ${BUILD_DIR}

build: admin_panel rop

admin_panel:
	gcc -m32 admin_panel.c -z execstack -fno-stack-protector -o ${BUILD_DIR}/admin_panel

rop:
	gcc -static -m32 admin_panel.c -fno-stack-protector -o ${BUILD_DIR}/admin_panel_rop
