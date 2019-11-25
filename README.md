# cci-link

# Tutoriel de mise en place d'une page

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

# Déclaration de la page dans le controller

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

