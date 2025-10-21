#include <stdio.h>
#include <string.h>
#include <errno.h>
#include <stdlib.h>

#define PASSLEN 32

char* realpass;

void shell() {
    system("/bin/sh");
}

void debugPassword() {
	if (realpass != NULL) {
		printf("%s\n", realpass);
	}
}

int getPasswordFromFile(){
    FILE *passwordFile;
    realpass = malloc(PASSLEN+1);

    passwordFile = fopen("/etc/sbadmin/admin.passwd", "r");
    if (passwordFile == NULL) {
        fprintf(stderr, "Could not open file password\n");
        return NULL;
    }
    fgets(realpass, PASSLEN+1, passwordFile);
    return realpass;
}

int checkPassword() {
    char password[PASSLEN+1];
    printf("Password: ");
    fgets(password, 322, stdin);
    return 1;
}

int main() {
    printf("Restricted Access - disabled for now we don't check for the password\n");
    char *password = getPasswordFromFile();
    if (password == NULL) {
       fprintf(stderr, "Could not get password\n");
       return 1; 
    }
    if (checkPassword() != 0) {
        fprintf(stderr, "Password is not valid\n");
        return 1;
    }
    shell();
    return 0;
}
