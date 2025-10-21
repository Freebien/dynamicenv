DIST = ../dist
CC = gcc
CFLAGS = -m32 -fno-builtin -o vuln_disable_all -fno-stack-protector -z execstack -no-pie

all: niveau1
.PHONY: all

%.c:
	$(CC) $(CFLAGS) -o $(DIST)/$@ $<
