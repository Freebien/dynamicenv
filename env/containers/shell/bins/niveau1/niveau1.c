#include <stdlib.h>
#include <stdio.h>
#include <string.h>

char* mdp = "MeG@pass";

void main() {
    char password[32];
    printf("###########################################\n");
    printf("############      Exercice 1      #########\n");
    printf("###########################################\n");
    printf("##  Objectif : Retrouver le bon MDP      ##\n");
    printf("###########################################\n");
    printf("Saisir le mot de passe: ");
    fgets(password, 0x14, stdin);
    if (strlen(mdp) != strlen(password) - 1) {
        printf("Tu ne te rappelles pas de la longueur de ton MDP ;) !!\n");
        exit(0);
    }
    if (strncmp(mdp, password, strlen(mdp)) == 0) {
        printf("Bravo !! tu as trouvé le bon passwrd\n");
        exit(0);
    }
    printf("Mauvais MDP :(\n");
    exit(0);
}
