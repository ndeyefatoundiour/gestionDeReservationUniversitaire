partie1

1. Quel est le rôle de Composer?Composer est le gestionnaire de dépendances officiel de l'écosystème PHP. Son rôle est d'automatiser le téléchargement des bibliothèques tierces, de résoudre leurs compatibilités de versions, et de générer un fichier d'autoloading standardisé (PSR-4) qui permet de charger automatiquement toutes vos classes PHP sans écrire de require ou d'include manuels.
2. Quelle différence existe entre require et require-dev ?require : Regroupe les packages indispensables au fonctionnement de l’application. Ces bibliothèques sont installées dans tous les environnements, y compris en production .require-dev : Contient les outils nécessaires uniquement pour le développement local ou les tests . Ils ne seront pas déployés sur le serveur de production.
3. Pourquoi faut-il versionner composer.lock ?Le fichier composer.lock enregistre les versions exactes (au commit près) de toutes les dépendances installées lors du dernier composer update. Le versionner garantit que tous les membres de l'équipe de développement et le serveur de production installeront exactement le même code, évitant des bug
4. Pourquoi ne versionne-t-on pas vendor/ ?Lourdeur : Le dossier vendor/ contient des milliers de fichiers de bibliothèques tierces, ce qui alourdirait inutilement votre dépôt Git.Redondance : Puisque le fichier composer.lock contient déjà la liste exacte et figée de ce qu'il faut installer, n'importe quel développeur ou serveur peut recréer le dossier vendor/ à l'identique en exécutant simplement la commande composer install.



partie2

1. Quel rôle joue Capsule\Manager ? Son rôle est de regrouper et d'initialiser manuellement tous les composants internes de la base de données de Laravel (gestionnaire de connexions, constructeur de requêtes, événements).
2. Pourquoi Eloquent peut-il fonctionner sans Laravel ?Eloquent peut fonctionner sans Laravel car l'équipe de développement a conçu ses composants de manière modulaire et découplée. Le package illuminate/database est une bibliothèque autonome enregistrée sur Packagist. Grâce à Composer, on peut extraire uniquement cette brique et l'installer dans n'importe quel projet PHP pur, sans avoir à charger tout le reste du framework Laravel.
3. Où doit se trouver le démarrage de l’ORM ?Le démarrage de l'ORM doit se trouver au tout début du cycle de vie de l'application, dans la phase d'initialisation technique.Dans l'architecture web, il est appelé dans le point d'entrée unique public/index.php (via le fichier config/database.php), il est chargé tout en haut du script avant toute interaction avec les modèles.
4. Quelle différence existe entre un ORM et du SQL écrit à la main ?La différence principale réside dans le niveau d'abstraction et la vitesse de développement :SQL écrit à la main (ex: PDO) : Le développeur doit écrire lui-même des requêtes textuelles brutes (SELECT * FROM...). C'est plus verbeux, sujet aux erreurs de syntaxe, et il faut convertir manuellement les tableaux de texte reçus en objets PHP.ORM (ex: Eloquent) : Il traduit automatiquement vos classes PHP en tables SQL [GoF]. Vous manipulez uniquement des objets et des méthodes PHP (Salle::find(1)). L'ORM s'occupe de générer le SQL en arrière-plan,



partie3

1. Quel type de relation Eloquent avez-vous utilisé ?Nous avons utilisé une relation One-to-Many (Un-vers-Plusieurs) bidirectionnelle  :HasMany (Possède plusieurs) dans le modèle Salle, car une salle peut faire l'objet de plusieurs réservations au fil du temps.BelongsTo (Appartient à) dans le modèle Reservation, car chaque réservation est rattachée à une seule et unique salle spécifique via la clé étrangère salle_id.
2. Pourquoi déclarer $fillable ou fillable agit comme une liste blanche : elle énumère les seuls champs qu'un utilisateur a le droit d'insérer ou de modifier d'un coup via un formulaire (ex: Reservation::create(guarded agit comme une liste noire : elle liste les champs strictement interdits à l'écriture automatique (comme id ou role).Note : L'ORM Eloquent vous oblige à configurer l'une de ces deux variables pour protéger votre base de données contre l'injection de données frauduleuses par un utilisateur malveillant.
3. Pourquoi convertir active en booléen ?Dans MySQL, les vrais types booléens n'existent pas nativement : ils sont stockés sous forme d'entiers génériques (0 pour faux, 1 pour vrai).Grâce au tableau salle->active).
4. Pourquoi convertir les dates en objets ?Par défaut, MySQL renvoie les dates sous forme de chaînes de caractères textuelles passives (ex: "2026-09-06 14:00:00"). On ne peut pas faire de calculs sur du texte.En les convertissant en objets (datetime), Eloquent les transforme automatiquement en instances .
