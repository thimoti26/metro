### Architecture

```scala
src
├── DataFixtures // Tests
│   └── AppFixtures.php
├── ImportBoundedContext // Importation des données
│   ├── Application
│   │   ├── CQRS
│   │   │   ├── Commands // Persistance des données
│   │   │   │   ├── PersistConnexionArrayCommand.php
│   │   │   │   ├── PersistGareArrayCommand.php
│   │   │   │   └── PersistLigneArrayCommand.php
│   │   │   └── Queries // Récupération des données
│   │   │       ├── FindConnexionByFileNameQuery.php
│   │   │       ├── FindGareByFileNameQuery.php
│   │   │       └── FindLigneByFileNameQuery.php
│   │   ├── Command
│   │   │   └── ImportCommand.php
│   │   ├── Controller // Utilisation de la partie ADR (1 Action par controlleur => single responsible). Gère la doc / serialize l'entitée, l'encapsule dans une Query/Command / et propage le message
│   │   │   └── Import
│   │   │       ├── GetAllController.php
│   │   │       ├── GetConnexionController.php
│   │   │       ├── GetGareController.php
│   │   │       └── GetLigneController.php
│   │   ├── Event
│   │   ├── EventSubscriber
│   │   ├── Handler // Récupère le message et call le(s) DAO(s)
│   │   │   ├── FindConnexionByFileNameHandler.php
│   │   │   ├── FindGareByFileNameHandler.php
│   │   │   ├── FindLigneByFileNameHandler.php
│   │   │   ├── PersistConnexionCollectionHandler.php
│   │   │   ├── PersistGareCollectionHandler.php
│   │   │   └── PersistLigneCollectionHandler.php
│   │   └── ViewModel // Héritent des entités et les surchagent avec des métadatas pour la doc (Aggregate)
│   │       ├── ConnexionArrayViewModel.php
│   │       ├── ConnexionIdViewModel.php
│   │       ├── ConnexionViewModel.php
│   │       ├── GareArrayViewModel.php
│   │       ├── GareIdViewModel.php
│   │       ├── GareViewModel.php
│   │       ├── LigneArrayViewModel.php
│   │       ├── LigneIdViewModel.php
│   │       └── LigneViewModel.php
│   ├── Domain
│   │   ├── Dao // Interface des DAOs implémentés dans l'infra (les databases et Files sont trop différents pour être généralisés)
│   │   │   ├── ConnexionDatabaseDaoInterface.php
│   │   │   ├── ConnexionFileDaoInterface.php
│   │   │   ├── GareDatabaseDaoInterface.php
│   │   │   ├── GareFileDaoInterface.php
│   │   │   ├── LigneDatabaseDaoInterface.php
│   │   │   └── LigneFileDaoInterface.php
│   │   └── Model // Root Entities
│   │       ├── Connexion
│   │       │   ├── Connexion.php
│   │       │   ├── ConnexionArrayObject.php
│   │       │   └── ConnexionIdValueObject.php
│   │       ├── File
│   │       │   └── FileNameValueObject.php
│   │       ├── Gare
│   │       │   ├── Gare.php
│   │       │   ├── GareArrayObject.php
│   │       │   └── GareIdValueObject.php
│   │       └── Ligne
│   │           ├── Ligne.php
│   │           ├── LigneArrayObject.php
│   │           └── LigneIdValueObject.php
│   └── Infrastructure // Implémentation des DAO
│       ├── DAO
│       │   ├── ConnexionDatabaseDao.php
│       │   ├── ConnexionFileDao.php
│       │   ├── GareDatabaseDao.php
│       │   ├── GareFileDao.php
│       │   ├── LigneDatabaseDao.php
│       │   └── LigneFileDao.php
│       ├── Exception // Liste des exceptions de l'infra
│       │   └── FileNotFoundException.php
│       ├── Model // Changement du modèle pour la source de donnée 
│       │   └── File // Pour la source file
│       │       └── Connexion // Aggrègate modèle Connexion pour matcher avec le DAO File Connexion
│       │           ├── Connexion.php
│       │           ├── ConnexionArrayObject.php
│       │           └── ConnexionIdValueObject.php
│       └── Orm // Interfaçage BDD
│           ├── Mapping // Fichiers de mapping entre les entités et la bdd
│           │   ├── Connexion.Connexion.orm.xml //Le nom corresponds à la localisation de l'entité dans le directory Domain/Model
│           │   ├── Gare.Gare.orm.xml
│           │   └── Ligne.Ligne.orm.xml
│           ├── Repository // Classes en charge de communiquer avec la bdd
│           │   ├── ConnexionRepository.php
│           │   ├── GareRepository.php
│           │   └── LigneRepository.php
│           └── Types // Rajout de nouveaux types de mapping pour gérer les transformations BDD / Entité (ex : valueObject)
│               ├── ConnexionIdMapping.php
│               ├── GareIdMapping.php
│               └── LigneIdMapping.php
├── Kernel.php
└── Shared //Librairies / Interfaces à respecter
    ├── Application
    │   └── CQRS 
    │       ├── Command.php // La data que l'on veut RÉCUPÉRER (contient un ValueObject du domaine et retourne un Objet du domaine)
    │       ├── CommandBus.php // Le bus de données (on utilise celui de base pour l'instant)
    │       ├── CommandHandler.php // L'objet responsable de communiquer avec le(s) DAO(s)
    │       ├── Query.php // La data que l'on veut RÉCUPÉRER (contient un ValueObject du domaine et retourne un Objet du domaine)
    │       ├── QueryBus.php // Le bus de données (on utilise celui de base pour l'instant)
    │       └── QueryHandler.php // Le bus de données (on utilise celui de base pour l'instant)
    ├── Domain
    │   └── Model // Pattern des entités de la couche modèle
    │       ├── ArrayObject.php
    │       ├── DateTimeValueObject.php
    │       ├── Entity.php
    │       ├── IntValueObject.php
    │       ├── StringValueObject.php
    │       └── ValueObject.php
    ├── Exception
    │   ├── InvalidCollectionParameterException.php
    │   └── InvalidConstructorArgumentsParameterException.php
    ├── Http
    ├── Infrastructure
    │   ├── Dao.php
    ├── Orm
    │   └── Migrations
    │       └── Version20230917115827.php
    └── Symfony
        ├── Normalizer // Permet la transformation d'objets typés en éléments sérialisés 
        │   ├── ArrayObjectNormalizer.php
        │   ├── DateTimeNormalizer.php
        │   ├── IntValueObjectNormalizer.php
        │   ├── StringValueObjectNormalizer.php
        │   └── ValueObjectNormalizer.php
        └── Serializer
            └── Serializer.php
```
# TODO
### Archi
1. Trouver un moyen de regroupper les mappings d'entité communs entre les BC dans le Shared (Ex : id).

### EventListener
1. Rajouter une EventListener sur l'entrée de la requète afin de serializer la donnée en entrée et de gérer une entité dans le post directement.
2. Rajouter une EventListener sur la sortie de la requète afin d'encapsuler la donnée dans une API Réponse.
