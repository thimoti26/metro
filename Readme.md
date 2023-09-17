### Architecture

```scala
src
├── DataFixtures            // Tests
│   └── AppFixtures.php
├── ImportBoundedContext    // Importation des données
│   ├── Application
│   │   ├── CQRS
│   │   │   ├── Commands    // Persistance des données
│   │   │   └── Queries     // Récupération des données
│   │   │       ├── FindConnexionByFileNameQuery.php
│   │   │       ├── FindGareByFileNameQuery.php
│   │   │       └── FindLigneByFileNameQuery.php
│   │   ├── Command
│   │   │   └── ImportCommand.php
│   │   ├── Controller      // Gère la doc / créé l'entité, l'encapsule dans une Query/Command / et propage le message
│   │   │   └── Import
│   │   │       ├── GetAllController.php
│   │   │       ├── GetConnexionController.php
│   │   │       ├── GetGareController.php
│   │   │       └── GetLigneController.php
│   │   ├── Event
│   │   ├── EventSubscriber
│   │   ├── Handler         // Récupère le message et call le(s) DAO(s)
│   │   │   ├── FindConnexionByFileNameHandler.php
│   │   │   ├── FindGareByFileNameHandler.php
│   │   │   └── FindLigneByFileNameHandler.php
│   │   └── ViewModel       // Héritent des entités et les surchagent avec des métadatas de présentation
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
│   │   ├── Dao             // Interface des DAOs implémentés dans l'infra
│   │   │   ├── ConnexionDatabaseDaoInterface.php
│   │   │   ├── ConnexionFileDaoInterface.php
│   │   │   ├── GareDatabaseDaoInterface.php
│   │   │   ├── GareFileDaoInterface.php
│   │   │   ├── LigneDatabaseDaoInterface.php
│   │   │   └── LigneFileDaoInterface.php
│   │   └── Model           // Entités
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
│   └── Infrastructure
│       ├── DAO                 // Implémentation des DAO
│       │   ├── ConnexionDatabaseDao.php
│       │   ├── ConnexionFileDao.php
│       │   ├── GareDatabaseDao.php
│       │   ├── GareFileDao.php
│       │   ├── LigneDatabaseDao.php
│       │   └── LigneFileDao.php
│       ├── Exception
│       │   └── FileNotFoundException.php
│       ├── Orm
│       │   ├── Entity
│       │   │   ├── ConnexionEntity.php
│       │   │   ├── GareEntity.php
│       │   │   └── LigneEntity.php
│       │   ├── Mapping
│       │   └── Repository
│       └── Repository
│           ├── ConnexionEntityRepository.php
│           ├── GareEntityRepository.php
│           └── LigneEntityRepository.php
├── Kernel.php
└── Shared
├── Application
│   └── CQRS
│       ├── Command.php
│       ├── CommandBus.php
│       ├── CommandHandler.php
│       ├── Query.php
│       ├── QueryBus.php
│       └── QueryHandler.php
├── Domain
│   └── Model
│       ├── ArrayObject.php
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
│   └── Repository.php
├── Orm
│   ├── Entity
│   │   ├── ConnexionEntity.php
│   │   ├── EntityInterface.php
│   │   ├── GareEntity.php
│   │   └── LigneEntity.php
│   └── Migrations
│       └── Version20230913095715.php
└── Symfony
├── Normalizer
│   ├── ArrayObjectNormalizer.php
│   ├── DateTimeNormalizer.php
│   ├── IntValueObjectNormalizer.php
│   ├── StringValueObjectNormalizer.php
│   └── ValueObjectNormalizer.php
└── Serializer
└── Serializer.php
```
