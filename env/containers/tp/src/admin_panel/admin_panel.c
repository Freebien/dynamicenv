#include <stdio.h>
#include <strings.h>

char *realpass;

void admin() {
    printf("Welcome to the admin panel\n");
    printf("It's currently in developpment, you should come back later\n");
}

void getPasswordFromFile(){
    FILE *passwordFile;
    realpass = malloc(20);

    passwordFile = fopen("/etc/sbadmin/admin_panel.passwd", "r");
    if (passwordFile == NULL) {
        printf("Could not open file password\n");
        return 1;
    }
    fgets(realpass, 20, passwordFile);
}

int checkPassword() {
    char password[20];
    printf("Password: ");
    fgets(password, 200, stdin);

    return strncmp(password, realpass, 19);
}

int main() {
    printf("Restricted Access \n");
    getPasswordFromFile();
    if (checkPassword() != 0) {
	    printf("Password is not valid\n");
        return 1;
    }
    admin();
    return 0;
}
