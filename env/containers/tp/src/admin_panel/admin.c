#include <stdio.h>
#include <string.h>
#include <errno.h>
#include <stdlib.h>

#define PASSLEN 32

void shell() {
    system("/bin/sh");
}

char *getPasswordFromFile(){
    FILE *passwordFile;
    char *realpass = malloc(PASSLEN);

    passwordFile = fopen("/etc/sbadmin/sbadmin.passwd", "r");
    if (passwordFile == NULL) {
        fprintf(stderr, "Could not open file password\n");
        return NULL;
    }
    fgets(realpass, PASSLEN, passwordFile);
    return realpass;
}

int checkPassword(char *realpass) {
    char password[PASSLEN];
    printf("Password: ");
    fgets(password, 200, stdin);

    return strncmp(password, realpass, PASSLEN);
}

int main() {
    printf("Restricted Access \n");
    char *password = getPasswordFromFile();
    if (password == NULL) {
       fprintf(stderr, "Could not get password\n");
       return 1; 
    }
    if (checkPassword(password) != 0) {
        fprintf(stderr, "Password is not valid\n");
        return 1;
    }
    shell();
    return 0;
}
