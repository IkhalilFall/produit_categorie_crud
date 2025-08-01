# Gestion Produits avec Panier (Symfony)

## Description

Cette application Symfony permet la gestion d'un catalogue de produits avec catégories, ainsi qu'un panier d'achat pour les utilisateurs.  
Les administrateurs peuvent gérer les produits et catégories, mais **n’ont pas accès au panier**.

---

## Fonctionnalités

- Gestion des produits : création, modification, suppression (admin uniquement)
- Gestion des catégories : création, modification, suppression (admin uniquement)
- Affichage du catalogue produits (utilisateurs et admins)
- Ajout, modification, suppression d’articles dans le panier (utilisateurs uniquement)
- Restriction d’accès au panier pour les administrateurs
- Affichage dynamique du nombre d’articles dans le panier dans la navbar (utilisateurs uniquement)
- Gestion sécurisée des accès selon les rôles (`ROLE_USER` et `ROLE_ADMIN`)
- Upload d’image produit avec gestion des fichiers

---

## Installation

1. **Cloner le dépôt**

```bash
git clone <URL_DU_DEPOT>
cd <nom_du_projet>
```

2. **Installer les dépendances**

```bash
composer install
npm install
npm run dev
```

3. **Configurer la base de données**

- Modifier `.env` ou `.env.local` avec tes paramètres DB (MySQL, PostgreSQL, etc.)

4. **Créer la base et exécuter les migrations**

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Lancer le serveur Symfony**

```bash
symfony server:start
```

---

## Structure

- **/src/Controller** : contrôleurs (ProduitController, PanierController, etc.)
- **/src/Entity** : entités (Produit, Categorie, CartItem, User)
- **/templates** : vues Twig
- **/public/uploads/produits** : dossiers d’upload des images produit

---

## Usage

- **Admin** :  
  - Accès aux pages de gestion produits et catégories
  - Pas d’accès au panier (redirection automatique)
- **Utilisateur** :  
  - Accès au catalogue, ajout au panier, modification et suppression dans le panier
  - Visualisation du panier avec mise à jour des quantités
  - Bouton “Ajouter au panier” visible uniquement pour utilisateurs (non admin)

---

## Sécurité

- Les routes liées au panier sont protégées par `ROLE_USER` uniquement.
- Tentatives d’accès par un admin sont bloquées avec redirection et message flash.
- Contrôle d’accès par rôle dans les templates pour afficher ou cacher certains boutons (ex : bouton “Ajouter au panier”).

---

## Routes principales

| Route                  | Description                      | Rôle requis             |
|------------------------|---------------------------------|-------------------------|
| `/produit/`            | Liste des produits               | `ROLE_USER`             |
| `/produit/new`         | Création produit                 | `ROLE_ADMIN`            |
| `/produit/{id}`        | Voir un produit                 | `ROLE_USER`             |
| `/panier/`             | Voir le panier                  | `ROLE_USER` (pas admin) |
| `/panier/ajouter/{id}` | Ajouter un produit au panier    | `ROLE_USER` (pas admin) |
| `/panier/modifier/{id}`| Modifier quantité dans panier   | `ROLE_USER` (pas admin) |
| `/panier/supprimer/{id}`| Supprimer un article du panier | `ROLE_USER` (pas admin) |
| `/panier/vider`        | Vider le panier                 | `ROLE_USER` (pas admin) |

---

## Contribution

Les contributions sont les bienvenues !  
Forkez le projet, faites vos modifications, puis proposez un pull request.

---

## Licence

Ce projet est sous licence MIT.
