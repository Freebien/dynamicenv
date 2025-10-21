#include <stdlib.h>
#include <stdio.h>
#include <string.h>

void main() {
    char mdp[15];
    char password[32];
    int i = 0;
    int passlen;
    mdp[14] = i;
    mdp[0] = 0x86;
    mdp[1] = 0x91;
    mdp[2] = 0x8c;
    mdp[3] = 0x9b;
    mdp[4] = 0x9a;
    mdp[5] = 0x9c;
    mdp[6] = 0x8b;
    mdp[7] = 0x92;
    mdp[8] = 0x92;
    mdp[9] = 0xda;
    mdp[10] = 0x96;
    mdp[11] = 0x97;
    mdp[12] = 0x8a;
    mdp[13] = 0xdf;
    printf("###########################################\n");
    printf("############      Exercice 3      #########\n");
    printf("###########################################\n");
    printf("##  Objectif : Retrouver le bon MDP      ##\n");
    printf("###########################################\n");
    printf("Saisir le mot de passe: ");
    fgets(password, 0x14, stdin);
    passlen = strlen(password) - 1;
    if (14 != passlen) {
        printf("Tu ne te rappelles pas de la longueur de ton MDP !!\n");
        exit(0);
    }
    for(i = 0; i < passlen; i++) {
        if(mdp[i] != (password[i] ^ 0xfffffffe)) {
           printf("Mauvais MDP :(\n");
           exit(0);
        }
    }

    printf("Bravo !! tu as trouve le MDP\n");
    exit(0);
}
