# cci-link

## Installation du projet

**Une fois le projet cloné :**

1. Installer composer avec la commande : ```> composer install```
2. Copier et coller le fichier **.env** puis le renommer en **.env.local** et modifier ```db_user``` & ```db_password``` à la ligne 32 : 
```DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/cci_link```
3. Créér la base de données : ```> php bin/console doctrine:database:create```
4. Puis : ```> php bin/console doctrine:schema:create```
5. Lancez la migration vers la base de données : ```> php bin/console doctrine:migrations:migrate```
6. Lancez le serveur puis rendez-vous sur http://127.0.0.1:8000/: ```> symfony server:start```

**Dans un autre terminal, pour lancer le compilateur :**

1. Lancez la commande : ```> npm install```
2. Puis lancer le watcher : ```> npm run watch```

## Tutoriel de mise en place d'une page

Afin de mettre en place une page sur le symfony, suivez les consignes suivantes:

**Créer une page dans le dossier :**
```
/templates/pages
```
>Créer la page avec un nom explicite (*exemple: home pour l'accueil*)

**Extends votre page avec la base en mettant en 1er ligne :**
```
{% extends "base.html.twig" %}
```
>Le extends permet de lier votre page à la base, permettant ainsi la déclaration des metas / js

**Ensuite, récupérer la page du templage dont vous avez besoin et repérer les balises :**
```
header et main:
<!-- Site header -->
    <header>
        ...
    </header>
<!-- END Site header -->
<!-- Main container -->
    <main>
        ...
    </main>
<!-- END Main container -->
```
**Important: Ne rien mettre d'autre dans votre page que le contenu de ces deux balises**

## Déclaration de la page dans le controller

**Une fois que votre page est prête, déclarer la dans le controller en suivant cette syntax :**
```
/**
     * @Route("/votreurl", name="nomlogiquedelapage")
     */
    public function nomlogiquedelapage()
    {
        return $this->render('pages/votrepage.html.twig', [
            'controller_name' => 'VotreController',
            'meta_title' => 'Le meta title de votre page',
            'meta_desc' => 'la meta description de votre page'
        ]);
    }
```
**Exemple de déclaration pour la page d'accueil**
```
/**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('pages/home.html.twig', [
            'controller_name' => 'HomeController',
            'meta_title' => 'CCI-LINK, votre site de rencontres professionnel au CFA',
            'meta_desc' => 'Description des metas'

        ]);
    }
```
>Important: Il faut créer les controllers en suivant des catégories logiques, toutes les pages "basiques" comme le login, accueil, faq, contact... ect vont dans le HomeController. Mais les pages qu'un étudiant va consulter doivent être déclarer dans un controller logique (*exemple: StudentController*) de façon à ne pas se perdre dans un seul controller
>Attention: Il est important de ne pas non plus créer 50k controller, on se perd sinon <3

***

## Project installation

**After cloning the project :**

1. Install composer by running the command : ```> composer install```
2. Copy and paste the file **.env** then rename it as **.env.local** and modify ```db_user``` & ```db_password``` on line 32 : 
```DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/cci_link```
3. Create the database : ```> php bin/console doctrine:database:create```
4. Then : ```> php bin/console doctrine:schema:create```
5. Make the migration to database : ```> php bin/console doctrine:migrations:migrate```
6. Launch server ang go to http://127.0.0.1:8000/: ```> symfony server:start```

**In another terminal, to launch the compiler :**

1. Run : ```> npm install```
2. Then run watcher : ```> npm run watch```


