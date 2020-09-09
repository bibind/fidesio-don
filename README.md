# fidesio-don
module magento fidesio for donation in checkout page

J'ai fait un fork de 
https://github.com/clean-docker/Magento2.git 

Pour pouvoir avoir des images avec les différentes version de php 7.0 /7.2/7.3 avec les différentes versions 
de Magento. La version 2.1 de magento est compatible avec php 7.0
Alors que les versions superieur sont compatible avec php 7.1 et superieur.
Il sera important de faire au moins deux images (deux dockerfiles)
Pour pouvoir tester les différentes version du module dans les différents environnement.

###Installation du module

private repository packagist

Mettre dans votre composer.json de votre projet Magento2 (si vous avez déja repositories, le mettre dans ce tableau) :

     "repositories" :[   {
                "type": "composer",
                "url": "https://repo.packagist.com/bibind/"
            },
            {
                "packagist.org": false
            }  
    ]

et dans la partie require :

        "fidesio/module-donation": "dev-master"

puis lancer les commande :

         `composer update mirror`
         
         `composer update `

Activer le module :
Se mettre dans le repertoir racine de Magento


    "./bin/magento setup:upgrade"
    "./bin/magento setup:di:compile"
    "./bin/magento setup:static-content:deploy"


Verifier que votre module est bien activer:

    "./bin/magento module:status"

------------------
Le module à mis une dépendance avec le modules :
experius/module-donationproduct qui a été une source d'inspiration .


Les problématiques du test :
Nous avons un module experius/module-donationproduct (https://github.com/experius/Magento-2-Module-Experius-DonationProduct)
qui permet de réaliser ces fonctionnalités mais en créeant des type de produit donation qui seront ajouter au panier, à la commande et la facture si le produit à été validé .

Manifestement ce module réponds pas exactement au test :
Je met explicitement ce module, pour mettre aussi en avant la question 
de l'utilité de développer un module  alors que nous avons déja un qui peut répondre à notre besoin
Et peut aussi remettre en question les besoins metiers .
1 - Administrable
On peux le désactiver dans le BO dans l'onglet advanced/advenced
-Il n'y a pas dans le BO, le titre l'image et la description  puisque c'est un produit.
Mais il donne la possiblité de donné un montant minimum, maximum et une liste de montant administrable .

L'implémentation des champs de configuration ressemble beaucoup à magento 1.
Ne pas oublier de faire un helper pour faire appel à ces champs de configuration.


J'ai pu créer un champ suplémentaire Donation_amount sur la quote
l'order et l'invoice (quote, saloe_order et sale_invoice et sale_order_grid) dans le setup/upgradeSchema

- A faire : verifier le systeme de version (qui n'est plus avec le nommage des fichiers comme dans Magento 1)
- A faire : verifier que la version de Magento 2.3 se différencie dans l'implémentation d'ajout de champs (via les fichier de config xml) On devra surement faire deux versions du module
- le champs en plus dans sales_order_grid nous permettra de voir le champ donation_amount dans la grille des commande.

- A faire : Pour les emails et pdf il sera simple d'insere la variable {{sale_order.donation_amount}} dans les templates respectifs.   

2 - Frontend
Le module experius/module-donationproduct
Le module experius/module-donationproduct du fait que le don est un produit pourra être visible sur l'ensemble des pages que l'on veut .
Pour le test il ne veut etre afficher que sur la page checkout avant le paiement : nous pouvons utiliser que le block de la list des produits de type donation
sur la page ge spécifier .
Et la list des montant apparait dans la popup
Nous avons un bouton "i want to donate" qui remplace la checkbox .

Notre module Fidesio/donation
Que veut le métier :
Comme j'imagine que le metier ou le client est dans ce test de mission impossible
est un simple contrôleur de code, les bests practices sont donc à respecter les plus possibles.
Avec Magento 2 il est important de bien comprendre et maitriser 
l'architecture des layout/block/uicomponent qui différe énorment de magento 1.
De nouveau templates et fichiers d'implémentaion xml ont été rajouter. 

J'ai eu le facheux reflexe de mettre les composants formulaire dans le template .phtml
alors qu'il est important d'utilisé les uicomponent de magento
qui permet une meilleur imbriquation entre la structure coté client (javascript, jquery, knout, etc.. ) 
et la structure coté serveur  (php)
Ma difficulter à été de trouver une conception pertinente dans le respect de l'architecture de magento2

- A finir : l'insertion de la checkbox via l'uicomponent et le block layoutprocessor
Je me suis aperçut que la mise à jour du panier, et du résumer du panier, ne peut se faire via
l'activation de la checkbox mais seulement par le onChange du select, j'ai perdu du temps...
L'activation de la checkbox activera le block donation (plus clair ou dégrisé seulement).
le click de la checkbox de sera qu'un changement d'opacité au block donation.



3 - montant du don
Avec le module le produit de type donation se retrouvera sur la quote, l'order et la facture avec les pdf générer .
Ce qui est un développement en moins . Encore une fois que veux le metier ?

Créer un controller ajax qui sera appeler lors du onChange du select (Choix des montants)
Il mettra à jour la quote avec le champs Donation_Amount
- verifier que le clonage de la quote à l'order et à l'invoice intgrera bien ce nouveau champs (comme dans Magento 1)

Créer le model collect pour intervenir sur le total et le subtotal qui devra mettre aussi 
a jour le frontend sur le total du panier, de la quote, et de l'order.

Créer un componant au sein du checkout_cart_index et checkou_index_index (controller et xml) summary pour insérer
la ligne Donation et son montant.

La difficulté est de bien faire interagire le process du checkout avec l'ajax, la mise à jour du Total, baseTotal  et les uicomponent.

Le controller met à jour la quote -> la mise à jour du Total avec le champs Donation_amount
-> Mise à jour du front avec les nouvelle données (aperçutjk de la ligne donation dans le summary)

- Il faudra prendre en compte l'evenement où l'internet désactive la checkbox 
-> mise à jour de la quote (on vide le champs donation_amount) etc
- Prendre en compte lorsque l'internaute ne désactive pas la checkbox mais remmet le select
à aucun choix 
-> idem que précedent .

4 - Bonus

