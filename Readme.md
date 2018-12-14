# Installer les dépendances :
`composer install`

# Créer la base de données 
`php bin/console doctrine:database:create`

# Exécuter les migrations :
`php bin/console doctrine:migrations:migrate`

# Démarrer le serveur local :
`php bin/console server:run`

# Générer une entité :
`php bin/console make:entity User`

# Générer la migration :
`php bin/console make:migration`

# Générer un formulaire :
`php bin/console make:form`

# Générer un fichier de fixtures :
`php bin/console make:fixtures`

# Importer les fixtures (le append permet de ne pas purger la base :
`php bin/console doctrine:fixtures:load --append`