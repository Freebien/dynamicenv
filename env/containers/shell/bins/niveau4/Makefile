DIST = ../dist
CC = gcc
CFLAGS = -m32 -fno-builtin -fno-stack-protector -z execstack
CFLAGS = -m32 -fno-builtin -o vuln_disable_all -fno-stack-protector -z execstack -no-pie

all: niveau4

.PHONY: all

%.c:
	$(CC) $(CFLAGS) -o $(DIST)/$@ $< && $(CC) $(CFLAGS) -static -o $(DIST)/$@rop $<
