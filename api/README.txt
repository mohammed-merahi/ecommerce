vous pouvez utiliser la base inclue  'api.sql'

Configuration de la BDD dans le fichier: 'Constants.php'

La clé de l'API c'est 0c81c1be0741a08d857f55e2dd0268b6 (dans la table 'rest')

- Les catégories

GET    /api/v1/categories 				---> toutes les categories
GET    /api/v1/categorie/id 			---> la categorie ayant l'id 'id'
POST   /api/v1/categorie/add			---> ajouter une categorie
PUT    /api/v1/categorie/update/id		---> modifier une categorie
DELETE /api/v1/categorie/delete/id		---> supprimer une categorie

- les familles d'articles

GET    /api/v1/fam_articles 			---> toutes les familles
GET    /api/v1/fam_article/id 			---> la famille ayant l'id 'id'
POST   /api/v1/fam_article/add			---> ajouter une famille
PUT    /api/v1/fam_article/update/id	---> modifier une famille
DELETE /api/v1/fam_article/delete/id	---> supprimer une famille

- les photos

GET    /api/v1/myphotos 			---> toutes les photos
GET    /api/v1/myphoto/id 			---> la photo ayant l'id 'id'
POST   /api/v1/myphoto/add			---> ajouter une photo
PUT    /api/v1/myphoto/update/id	---> modifier une photo
DELETE /api/v1/myphoto/delete/id	---> supprimer une photo

- marques

GET    /api/v1/marques 				---> toutes les marque
GET    /api/v1/marque/id 			---> la marque ayant l'id 'id'
POST   /api/v1/marque/add			---> ajouter une marque
PUT    /api/v1/marque/update/id		---> modifier une marque
DELETE /api/v1/marque/delete/id		---> supprimer une marque

- mylogo

GET    /api/v1/mylogos 			---> tous les logo
GET    /api/v1/mylogo/id 		---> le logo ayant l'id 'id'
POST   /api/v1/mylogo/add		---> ajouter un logo
PUT    /api/v1/mylogo/update/id	---> modifier un logo
DELETE /api/v1/mylogo/delete/id	---> supprimer un logo

- familles clients


- ccs


- cmds_clients


- clients


- articles