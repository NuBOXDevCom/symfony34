# Démonstration
> Site de demonstration
- [http://symfony-demo.nubox.fr](http://symfony-demo.nubox.fr)

> Identifiants
- Administrateur => admin / admin
- Utilisateur => user / user

> Paiements de test avec Stripe
Fournir les informations ci-dessous pour tester les paiements:
- Numéro de carte: 4242 4242 4242 4242
- Exp: 12/19
- CCV: 123
- Code Postal: 75000

# Installation
> Cloner le repo
```bash
git clone https://github.com/NuBOXDevCom/symfony34.git
```

> Se rendre dans le dossier symfony34 et installer les vendors comme ceci:
```bash
composer install
```

> Paramétrer les fichiers suivants avec vos informations:
- parameters.yml
- stripe_config.yml
- mailtrap_config.yml

> Initialiser la base de donnée comme ceci:
```bash
bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load
```

> Démarrez le serveur php interne de Symfony
```bash
bin/console server:run
```

> C'est terminé ! Rendez-vous sur [http://localhost:8000](http://localhost:8000) ;)
