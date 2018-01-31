[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e648eda0-56e4-4658-9b59-52096d18f95d/big.png)](https://insight.sensiolabs.com/projects/e648eda0-56e4-4658-9b59-52096d18f95d)

# Installation
> Cloner le repo
```console
git clone git@github.com:NuBOXDevCom/symfony34.git
```

> Se rendre dans le dossier symfony34 et installer les vendors comme ceci:
```console
composer install
```

> Paramétrer les fichiers suivants avec vos informations:
- parameters.yml
- stripe_config.yml
- mailtrap_config.yml

> Initialiser la base de donnée comme ceci:
```console
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load
```

> Démarrez le serveur php interne de Symfony
```console
bin/console server:run
```

> C'est terminé ! Rendez-vous sur http://localhost:8000 ;)
