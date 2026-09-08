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



partie4

1. Quelle différence existe entre migration et seeder ?La Migration (migration.php) : Elle définit le plan d'architecte et la structure . Elle crée les conteneurs (les tables, les types de colonnes comme VARCHAR ou INT, les clés primaires et les contraintes de clés étrangères) . Elle ne contient aucune donnée utilisateur.Le Seeder (seed.php) : Il s'occupe du contenu et des données initiales. Une fois les conteneurs créés par la migration, le seeder vient peupler la base de données avec des lignes concrètes (ici, vos 5 salles de test) pour que l'application soit immédiatement utilisable ou testable.
2. Pourquoi les données initiales doivent-elles être reproductibles ?Les données doivent être reproductibles (c'est-à-dire qu'exécuter le script plusieurs fois doit donner exactement le même résultat final sans casser l'application) pour trois raisons majeures :La collaboration : Si un autre développeur (ou votre professeur) récupère votre projet sur sa machine, il doit pouvoir installer et lancer les scripts en une commande pour obtenir exactement le même environnement de test que vous.
3. Comment empêcher les doublons ?Pour empêcher les doublons, on utilise une stratégie combinée entre la base de données et le code PHP :Côté Base de données (Contrainte) : Lors de la migration, on peut définir une colonne comme unique() (par exemple le nom de la salle). MySQL rejettera alors techniquement toute tentative d'insertion d'un nom déjà existant.



partie5

1. Pourquoi séparer la validation syntaxique des règles métier ?Performance  : La validation syntaxique se fait entièrement en mémoire. Elle est ultra-rapide et peu coûteuse. Séparer les deux permet de rejeter immédiatement une mauvaise requête  avant même de solliciter la base de données MySQL. Responsabilité unique  : Un validateur de formulaire ne doit s'occuper que de la cohérence de la saisie utilisateur. Les règles métier  dépendent de l'état actuel de l'application et doivent rester isolées dans un Service.
2. Pourquoi créer une interface de validation ?L'interopérabilité : En créant ValidatorInterface, vos contrôleurs ne dépendent pas d'une classe concrète, mais d'un contrat général. Vous pourrez facilement remplacer SalleValidator par un autre validateur ou créer de nouvelles entités sans jamais modifier le code qui les appelle. Facilité pour les tests unitaires
3. Pourquoi le validateur ne doit-il pas enregistrer les données ?Absence d'effets secondaires (Fonctions pures) : Un validateur est conçu pour être une fonction "pure" : il reçoit des données, donne un résultat d'analyse, et s'arrête là. S'il enregistrait en base de données, il violerait le principe de séparation des responsabilités.Contrôle du flux applicatif : L'enregistrement en base de données (via l'ORM) est l'étape finale. . C'est au Service  d'ordonner l'enregistrement, jamais au validateur. .
4. Comment retourner plusieurs erreurs en une seule fois ?L'utilisation d'un tableau accumulateur : Au lieu d'utiliser des exceptions (qui bloquent le script à la toute première erreur rencontrée), votre code utilise un tableau
