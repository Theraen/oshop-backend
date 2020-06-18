<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController{

    /**
     * Methode s'occupant de lister les categories
     * 
     */

     public function list() {

      
        $_SESSION['token'] = bin2hex(random_bytes(32));

        $allBrand = Brand::findAll();

        $this->show('brand/list', [
            'allBrands' => $allBrand
        ]);

     }

     /**
      * Methode s'occupant de gérer l'ajout d'une nouvelle categorie
      */

      public function add() {

        $_SESSION['token'] = bin2hex(random_bytes(32));

          $this->show('brand/create-update', [
            'mode' => 'create'
          ]);
      }

      /**
      * Methode s'occupant de gérer l'update d'une categorie
      */

      public function update($params)
      {  

        $_SESSION['token'] = bin2hex(random_bytes(32));

          $brand = Brand::find($params);
  
          $this->show('brand/create-update', [
              'brand' => $brand,
              'mode' => 'update'
          ]);
      }


      public function delete($params) {

        

        $brand = Brand::find($params);

        $deleted = $brand->delete();
           

            // Si tous c'est bien passé
            if($deleted) {
                // On va dire à notre serveur WEB de dire au navigateur WEB d'aller sur une autre URL
                // C'est le principe de la "redirection"

                // Pour ce faire il faut que le serveur WEB envoi en réponse de la requete HTTP
                // Un header de type "Location:"

                // un peu crade mais necessaire ici
                global $router;

                // A partir de là je vais indiquer à mon navigateur d'aller sur cette URL là.
                header('Location: ' . $router->generate('brand-list'));

                // j'arrête l'execution de ma méthode là.
                return;
            }
            // Si au contraire il y a eu un soucis
            else {
                // on ajoute un message d'erreur
                $errorList[] = 'La suppresion a échoué, merci de retenter';
            }

      }

      public function createEdit($brand_id = null)
      {

         
          // Si on ne m'a pas fourni d'id de marque
          if (is_null($brand_id)) {
  
              // C'est qu'on souhaite créer la marque
              $mode = 'create';
  
          // Sinon...
          } else {
  
              // C'est qu'on souhaite modifier la marque!
              $mode = 'update';
  
              // Je récupere la marque dont l'id est passé dans l'url
              $brand = Brand::find($brand_id);
  
              // SI la marque n'existe pas en base...
              if (empty($brand)) {
  
                  // On envoie le header 404
                  header('HTTP/1.0 404 Not Found');
  
                  // Puis on gère l'affichage
                  return $this->show('error/err404');
              }
          }
  
          // Comme le formulaire à été soumis en POST
          // PHP me propose d'acceder aux données du formulaire via $_POST
          // dd($_POST);
  
          // On tente de récuperer les données venant du formulaire
          $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  
          //On va vérifier si les champs du formulaire sont bien renseignée
          $errorList = [];
  
          // Si le nom de la categorie est vide...
          if (empty($name)) {
  
              $errorList[] = 'Le nom de la marque est vide';
          }
  
          // Si le nom de la categorie est trop petit...
          if (strlen($name) < 3) {
  
              $errorList[] = 'Le nom de la marque doit comporter 3 caractères minimum';
          }
  
          // TODO continuer les controlles si besoin...
  
          // Si il n'y a pas d'erreurs dans mon tableau qui les listes...
  
  
  
          // Si il n'y a pas d'erreurs dans mon tableau qui les listes...
  
          if (empty($errorList)) {
  
              // En mode de création, on souhaite créé une nouvelle marque
              if ($mode == 'create') {
  
                  // On instancie donc un nouveau modèle (vide) de type Brand.
                  $brand = new Brand();
              }
  
              // Si je ne suis pas en mode de création, c'est que j'ai déjà une instance
              // du produit que je souhaite modifier.
  
              // On met à jour les propriétés de l'instance.
              $brand->setName($name);
  
  
              /*
              // En mode de création, je vais un insert
              if ($mode == 'create') {
                  // Maintenant que mon instance de la classe Product
                  // à bien des données dans ces propriétés
                  // Il ne me reste plus qu'a inserer le contenu dans la bonne table en BDD
                  $queryExecuted = $product->insert();
  
              // En mode de modification, je vais faire un update
              } else {
  
                  $queryExecuted = $product->update();
              }
              */
  
              /*
              Finalement le code au dessus n'est pas des plus pratique...
              En effet il m'oblige dans mon controller (et donc pour chaque utilisation d'un model)
              de devoir différencier la création d'une ligne en base de la modification.
  
              Pour executer ->insert() ou bien ->update().
  
              Il serait plus commode d'avoir pour chacun des models une méthode ->save()
              dont le role serait d'executer ->insert() ou ->update() en fonction de la présence
              ou non de la propriété id du dit model.
              */
              $queryExecuted = $brand->save();
  
              // Si tout c'est bien passé
              if ($queryExecuted) {
  
                  // On va dire à notre serveur WEB de dire au navigateur WEB d'aller sur une autre URL
                  // C'est le principe de la "redirection"
  
                  // Pour ce faire il faut que le serveur WEB envoi en réponse de la requete HTTP
                  // un header de type "Location:"
  
                  // Un peu crade mais necessaire ici
                  global $router;
  
                  if ($mode == 'create') {
                      // A partir là je vais indiquer à mon navigateur d'aller sur cette URL là
                      header('Location: '.$router->generate('brand-list'));
  
                  } else {
  
                      // A partir là je vais indiquer à mon navigateur d'aller sur cette URL là
                      header('Location: '.$router->generate('brand-update', ['idBrand' => $brand->getId()]));
                  }
  
                  // J'arrete l'execution de ma méthode là
                  return;
  
  
              // Si au contraire il y a eu un soucis
              } else {
  
                  // On ajoute un message d'erreur.
                  $errorList[] = 'La sauvegarde a échoué, merci de retenter';
              }
          }
  
          // Si au contraire j'ai des erreurs dans mon tableau de listing des erreurs...
          if (!empty($errorList)) {
  
              // On réaffiche le formulaire, mais pré-rempli avec les (mauvaises) données
              // proposées par l'utilisateur.
              // Pour ce faire, on instancie un modèle Product, qu'on passe au template.
              $brand = new Brand();
              $brand->setName(filter_input(INPUT_POST, 'name'));

              // Je charge ma vue
              $this->show('brand/create-update', [
                  // Je partage à ma vue ma category
                  'brand' => $brand,
                  // Je partage à ma vue la liste des erreurs
                  'errorList' => $errorList,
                  'mode' => $mode
              ]);
          }
      }

}