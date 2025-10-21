#include <stdio.h>
#include <string.h>
#include <unistd.h>
#include <stdlib.h>

#define LICENSELEN 32

char *getLicenseFromFile(){
    FILE *licenseFile;
    char *license = malloc(LICENSELEN);

    licenseFile = fopen("/etc/sbadmin/license.key", "r");
    if (licenseFile == NULL) {
        fprintf(stderr, "Could not open file license\n");
        return NULL;
    }
    fgets(license, LICENSELEN, licenseFile);
    return license;
}

int checkLicense(char* license, char* reallicense) {
    int check = 0;
    if (strncmp(license, reallicense, LICENSELEN) == 0) {
        return 0;
    }
    return 1;
}

int main(int argc, char *argv[]) {
    int debug = 0;
    int lfnd = 0;
    char* license;
    char* reallicense;
    int opt;
    while ((opt = getopt(argc, argv, "dl:")) != -1) {
        switch (opt) {
        case 'd':
            debug = 1;
            break;
        case 'l':
            license = optarg;
            lfnd = 1;
            break;
        default:
            fprintf(stdout, "Usage: %s [-l] license\n",
                    argv[0]);
            exit(EXIT_FAILURE);
        }
    }
    if (lfnd == 0) {
            fprintf(stdout, "Usage: %s [-l] license\n",
                    argv[0]);
            exit(EXIT_FAILURE);
    }

    reallicense = getLicenseFromFile();
    if(reallicense == NULL) {
        exit(EXIT_FAILURE);
    }
    if (debug != 0) {
        printf("license: %s\n", reallicense);
    }

    if (checkLicense(license, reallicense) == 0) {
        printf("License key is good\n");
        return 0;
    }
    printf("License key is not good\n");
    return 1;
}
