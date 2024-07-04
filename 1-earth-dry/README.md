# STRUCTURE D'APPLICATION #1 - DRY

> Le code d'une application web vous est fourni.\
> L'objectif est de réduire voire d'éliminer le code dupliqué.\
> Pour cela, nous allons procéder par étapes.\
> A la fin, nous aurons une structure relativement élaborée, avec un unique point d'entrée.

## ETAPE 1 : include

### On renomme...

- Renommer les fichiers .html en .php
- Adapter les liens de menu en conséquence

### On regroupe le code

- Identifier les parties de code dupliquées.
- Regrouper ces parties de code dans des fichiers séparés.
- Inclure (avec include) ces fichiers dans les pages.

## ETAPE 2 : restructuration du système de dossiers et fichiers

### On configure

- Créer un dossier *src*
- Créer un dossier *src/config*
- Dans *src/config*, créer un fichier *config.php*
- Dans *src/config/config.php*, créer une constante TEMPLATE_PARTS (avec define()) contenant le chemin suivant : *src/template/template-parts*

### On structure

- Dans *src*, créer un dossier *template*
- Dans *src/template*, créer un dossier *template-parts*
- Placer les fichiers php comprenant des parties de pages (header, footer,...) dans ce dossier *src/template/template-parts*
- Adapter les chemins dans les include en utilisant la constante TEMPLATE_PARTS

### On range

- Créer un dossier *public* à la racine du projet
- Créer un dossier *assets* dans le dossier *public*
- Créer une constante ASSETS contenant le chemin *public/assets*
- Déplacer le dossier *css* dans le dossier *public/assets*
- Adapter les chemins des balises Link et Script, ainsi que ceux des images en utilisant la constante ASSETS
- Créer une constante TITLE contenant "Earth"
- Adapter la balise title des différentes pages en conséquence (toutes les pages auront le même title)

### On teste

- Créer la page **Contact** (uniquement le formulaire) en vous inspirant de cet exemple : [Earth Theme](https://websitedemos.net/earth-02)
