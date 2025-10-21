#include <stdlib.h>
#include <stdio.h>
#include <string.h>

char* mdp = "passwordbidon";

void callMeMaybe() {
    printf("\n \n  ----> Bravo, tu as exploit\357\277\275 ton premier Buffer Overflow \n");
    exit(0);
}

void checkPassword() {
    char password[0x1c];
    printf("Saisir le mot de passe: ");
    fgets(password, 0xc8, stdin);
    if(strncmp(mdp, password, 0xd) == 0) {
        printf("Tu as trouv\357\277\275 le MDP, mais ce n'est pas ce qu'il faut faire ..  \n");
        exit(0);
    }
}


int main() {
    printf("#########################################################\n");
    printf("##################       Exercice 4     #################\n");
    printf("#########################################################\n");
    printf("##  Objectif 1 : Appeller le fonction 'callMeMaybe'    ##\n");
    printf("##  Objectif 2 : Obtenir un shell                      ##\n");
    printf("##  Indice : Stack Overflow, shellcode                 ##\n");
    printf("#########################################################\n");
    checkPassword();
    return 0;
}
