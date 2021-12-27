# SCRUMBAN
## Projet CDP

### Fonctionnalités attendues :

En tant qu’utilisateur, je souhaite pouvoir me connecter à l’application via un nom d’utilisateur et un mot de passe

En tant qu’utilisateur, je souhaite pouvoir m’inscrire à l’application via un nom d’utilisateur et un mot de passe

En tant qu’utilisateur, je souhaite pouvoir créer un projet sur l’application

En tant qu’utilisateur, je souhaite pouvoir rejoindre un projet sur l’application

En tant qu’utilisateur, je souhaite pouvoir créer autant de colonnes que je souhaite dans mon tableau kanban

En tant qu’utilisateur, je souhaite pouvoir personnaliser le nombre d’éléments maximum d’une colonne dans mon tableau kanban

En tant qu’utilisateur, je souhaite que mes projets, sprints, tableaux kanban et tâches soient sauvegardées afin de les retrouver lors d’une prochaine connexion

En tant qu’utilisateur, je souhaite pouvoir créer une tâche et l’ajouter aux colonnes de mon tableau kanban

En tant qu’utilisateur, je souhaite pouvoir déplacer les tâches d’une colonne à une autre via un système de « drag and drop »

En tant qu’utilisateur, je souhaite pouvoir créer un nouveau sprint au sein d’un projet déjà existant

### Tableau de données :
> TÂCHES (POST-IT) :
-	Couleur
-	Titre
-	Description
-	Assignation
-	Date de création
-	Estimation
-	Log de changement de colonnes (qui et quand)
> COLONNES KANBAN :
-	Titre
-	Liste de tâches
-	Ordre
-	Nombre de tâches maximum par colonnes (facultatif)
> UTILISATEUR :
-	Nom d’utilisateur
-	Mot de passe
> PROJET
-	Titre
-	Date de création
-	Liste de sprints
-	Liste d’utilisateur
-	Product backlog
-	Log des sprints
> SPRINT
-	Date de début
-	Date de fin
-	Liste de tâches
-	Tableau KANBAN
-	Planning daily et retrospective

### Spécifications techniques :
Pas d’obligations au niveau du langage
Pas d’obligations au niveau du système de base de donnée
L’utilisation de bootstrap ou autre framework visuel est fortement recommandé
