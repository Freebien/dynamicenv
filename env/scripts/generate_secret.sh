#!/bin/sh

generateSecret() {
    p=$(LC_ALL=C tr -dc '[:alpha:][:digit:]' </dev/urandom | head -c ${1:-13})
    echo "#FLAG{$p}#"
}