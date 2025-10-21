#include <stdlib.h>
#include <stdio.h>
#include <string.h>

void main() {
    char mdp[10];
    char password[32];
    int i = 0;
    int passlen;
    mdp[0] = 'b';
    mdp[1] = 'u';
    mdp[2] = 'l';
    mdp[3] = 'l';
    mdp[4] = '$';
    mdp[5] = 'h';
    mdp[6] = 'i';
    mdp[7] = 't';
    mdp[8] = '!';
    mdp[9] = 0;
    printf("###########################################\n");
    printf("############      Exercice 2      #########\n");
    printf("###########################################\n");
    printf("##  Objectif : Retrouver le bon MDP      ##\n");
    printf("###########################################\n");
    printf("Saisir le mot de passe: ");
    fgets(password, 0x14, stdin);
    passlen = strlen(password) - 1;
    if (9 != passlen) {
        printf("Tu ne te rappelles pas de la longueur de ton MDP !!\n");
        exit(0);
    }
    for(i = 0; i < passlen; i++) {
        if(mdp[i] != password[i]) {
           printf("Mauvais MDP :(\n");
           exit(0);
        }
    }

    printf("Bravo !! tu as trouvé e MDP\n");
    exit(0);
}
