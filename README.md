# fidesio-don
module magento fidesio for donation in checkout page

Les problématiques du test :
Nous avons un module experius/module-donationproduct (https://github.com/experius/Magento-2-Module-Experius-DonationProduct)
qui permet de réaliser ces fonctionnalités mais en créeant des type de produit donation qui seront ajouter au panier, à la commande et la facture si le produit à été validé .

Manifestement ce module réponds pas exactement au test :

1 - Administrable
On peux le désactiver dans le BO dans l'onglet advanced/advenced

-Il n'y a pas dans le BO, le titre l'image et la description  puisque c'est un produit.
Mais il donne la possiblité de donné un montant minimum, maximum et une liste de montant administrable .

2 - Frontend
Notre module du fait que le don est un produit pourra être visible sur l'ensemble des pages que l'on veut .
Pour le test il ne veut etre afficher que sur la page checkout avant le paiement : nous pouvons utiliser que le block de la list des produits de type donation
sur la page ge spécifier .
Et la list des montant apparait dans la popup
Nous avons un bouton "i want to donate" qui remplace la checkbox .
Que veut le métier : 
Absolument un checkbox, et ne veut pas de que ça soit un produit ?

3 - montant du don
Avec le module le produit de type donation se retrouvera sur la quote, l'order et la facture avec les pdf générer .
Ce qui est un développement en moins . Encore une fois que veux le metier ?

4 - Bonus
Le module propose une liste des donation filtrable avec l'id de l'order.
Ce n'est pas ce qui est demandé. Sur la liste des order ou commande , mettre un attribu

