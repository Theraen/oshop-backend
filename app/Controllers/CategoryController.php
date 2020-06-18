<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController {

    /**
     * Méthode s'occupant de lister les catégories
     *
     * @return void
     */
    public function list()
    {

        $_SESSION['token'] = bin2hex(random_bytes(32));

       
        /*

        Ancien fonctionnement avec findAll lié à l'instance

        // Création d'une nouvelle instance (donc vide)
        // de la classe Category
        // Il est également possible de dire que $emptyCategory
        // est un objet (ici vide) de type Category
        $emptyCategory = new Category();

        // Appel de la méthode findAll() sur notre instance
        // $emptyCategory de la classe Category.
        // Le résultat est ensuite stocké dans ma variable
        // $allCategories.
        $allCategories = $emptyCategory->findAll();

        */

        /*

        Nouveau fonctionnement avec findAll en static

        Pour info:
        static signifie que la méthode n'est pas liée
        à l'instance mais directement à la classe.

        Lorsque nous réalisons des appels de méthode, nos appels
        sont executé sur des instances. En effet les méthodes
        sont là pour retourner des informations concernant l'instance.
        Ex:
            $myCategory->getName(); // Donne moi le nom de ma catégorie instanciée
            $myCategory->getId(); // Donne moi l'id de ma catégorie instanciée

        Maintenant il est parfois necessaire d'avoir des méthodes qui ne dépendent pas
        d'une instance en particulier.
        Typiquement les méthodes find() et findAll() peuvent fonctionner quelque soit l'instance.
        En effet je n'ai pas besoin de connaitre une information spécifique pour retourner un produit
        ou plusieurs.
        Ex:
            -je n'ai pas besoin de connaitre le nom d'une catégorie en particulier pour toutes les récupérer.

        Du coup la solution est de passer nos méthodes "générique" (autrement dit où une instance n'est pas necessaire)
        en static.

        Ainsi il sera possible d'executer la méthode directement depuis le nom de la classe
        et non plus uniquement depuis l'instance de la classe.

        Ex:
            Category::findAll();

        Il est possible de généraliser ainsi:

            Une méthode qui utilise $this est donc liée à l'instance de la classe: IMPOSSIBLE de la déclarer en static

            Une méthode qui n'UTILISE PAS $this n'est pas liée à l'instance de la classe: il est donc possible (mais pas obligatoire) de la déclarer en static

            Résumé by gregory:
                Toutes les fonctions génériques (indépendantes) peuvent être static

        L'interet final étant qu'on est plus obliger d'instancier une classe vide pour executer une méthode.

        Pour info:
            -> Est l'opérateur de résolution de portée d'une instance
            :: Est l'opérateur de résolution de portée static

        */

        // Récupération de toutes les categories sous la forme d'un tableau indexé
        // A chaque clé de mon tableau se trouve une instance de la classe Category avec des valeurs (propriétés)
        // renseignées en provenance de la table category en base de donnée
        $allCategories = Category::findAll();

        // Execution de la méthode show afin de générer la construction du HTML
        $this->show('category/list', [
            // Je partage à ma vue ma variable $allCategories afin de pouvoir l'exploiter
            // dans ma vue pour construire le HTML correspondant
            'allCategories' => $allCategories
        ]);
    }

    /**
     * Méthode s'occupant d'afficher le formulaire d'ajout d'une nouvelle catégorie
     *
     * Méthode HTTP: GET
     *
     * @return void
     */
    public function add()
    {

        $_SESSION['token'] = bin2hex(random_bytes(32));
        
        $this->show('category/create-update', [
            'mode' => 'create'
        ]);
    }

    public function updateHome()
    {

        $_SESSION['token'] = bin2hex(random_bytes(32));

        $this->show('category/update-home');
    }


    /**
     * Méthode qui permet d'afficher le formulaire de modification d'une catégorie
     *
     * Méthode HTTP: GET
     *
     * @return void
     */
    public function update($category_id)
    {
        
        $_SESSION['token'] = bin2hex(random_bytes(32));

        // Je cherche à récuperer la catégorie que l'on souhaite modifier
        $category = Category::find($category_id);

        // En premier lieu, je vérifie si elle existe bien !
        if (empty($category)) {

            // On envoie le header 404
            header('HTTP/1.0 404 Not Found');

            // Puis on gère l'affichage
            return $this->show('error/err404');
        }

        // A partir de maintenant, je sais que ma catégorie existe bien..

        $this->show('category/create-update', [
            'category' => $category,
            'mode' => 'update'
        ]);
    }

    public function delete($params) {

        


        $category = Category::find($params);

        $deleted = $category->delete();
           

            // Si tous c'est bien passé
            if($deleted) {
                // On va dire à notre serveur WEB de dire au navigateur WEB d'aller sur une autre URL
                // C'est le principe de la "redirection"

                // Pour ce faire il faut que le serveur WEB envoi en réponse de la requete HTTP
                // Un header de type "Location:"

                // un peu crade mais necessaire ici
                global $router;

                // A partir de là je vais indiquer à mon navigateur d'aller sur cette URL là.
                header('Location: ' . $router->generate('category-list'));

                // j'arrête l'execution de ma méthode là.
                return;
            }
            // Si au contraire il y a eu un soucis
            else {
                // on ajoute un message d'erreur
                $errorList[] = 'La suppresion a échoué, merci de retenter';
            }

      }

    public function editHome() {

        // On tente de récuperer les données venant du formulaire
        $emplacement = $_POST['emplacement'];


        // Si le tableau est vide...
        if (empty($emplacement)) {

            $errorList[] = 'Il me semble qu\'il y a une erreur dans les données transmise ...';
        }

        if (empty($errorList)) {
            foreach ($emplacement as $key => $home_order) {
                $error = 0;
                $category = Category::find($home_order);
                $order = $key+1;
                $queryExecuted = $category->updateHome($order);

                if(!$queryExecuted) {
                    $error = $error++;
                }
            }

            // Si tout c'est bien passé
            if ($error === 0) {

                // On va dire à notre serveur WEB de dire au navigateur WEB d'aller sur une autre URL
                // C'est le principe de la "redirection"

                // Pour ce faire il faut que le serveur WEB envoi en réponse de la requete HTTP
                // un header de type "Location:"

                // Un peu crade mais necessaire ici
                global $router;

                // A partir là je vais indiquer à mon navigateur d'aller sur cette URL là
                header('Location: '. $router->generate('category-update-home'));
                

                // J'arrete l'execution de ma méthode là
                return;


            // Si au contraire il y a eu un soucis
            } else {

                // On ajoute un message d'erreur.
                $errorList[] = 'La sauvegarde a échoué, merci de retenter';
            }
        } else {


            // Je charge ma vue
            $this->show('category/create-update', [
                // Je partage à ma vue la liste des erreurs
                'errorList' => $errorList

            ]);
        

        }

    }


    public function createEdit($category_id = null)
    {
        

        // Si on ne m'a pas fourni d'id de categorie
        if (is_null($category_id)) {

            // C'est qu'on souhaite créer la catégorie
            $mode = 'create';

        // Sinon...
        } else {

            // C'est qu'on souhaite modifier la categorie!
            $mode = 'update';

            // Je récupere la catégorie dont l'id est passé dans l'url
            $category = Category::find($category_id);

            // SI la catégorie n'existe pas en base...
            if (empty($category)) {

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
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_URL);

        //On va vérifier si les champs du formulaire sont bien renseignée
        $errorList = [];

        // Si le nom de la categorie est vide...
        if (empty($name)) {

            $errorList[] = 'Le nom de la catégorie est vide';
        }

        // Si le nom de la categorie est trop petit...
        if (strlen($name) < 3) {

            $errorList[] = 'Le nom de la catégorie doit comporter 3 caractères minimum';
        }

        // Si je n'ai pas passé le filtre
        if ($subtitle === false) {

            $errorList[] = 'Le sous-titre est invalide';
        }

        // Si je n'ai pas passé le filtre
        if ($picture === false) {

            $errorList[] = 'L\'url de l\'image est invalide';
        }

        // TODO continuer les controlles si besoin...

        // Si il n'y a pas d'erreurs dans mon tableau qui les listes...



        // Si il n'y a pas d'erreurs dans mon tableau qui les listes...

        if (empty($errorList)) {

            // En mode de création, on souhaite créé une nouvelle catégorie
            if ($mode == 'create') {

                // On instancie donc un nouveau modèle (vide) de type Category.
                $category = new Category();
            }

            // Si je ne suis pas en mode de création, c'est que j'ai déjà une instance
            // du produit que je souhaite modifier.

            // On met à jour les propriétés de l'instance.
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);


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
            $queryExecuted = $category->save();

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
                    header('Location: '.$router->generate('category-list'));

                } else {

                    // A partir là je vais indiquer à mon navigateur d'aller sur cette URL là
                    header('Location: '.$router->generate('category-update', ['idCategory' => $category->getId()]));
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
            $category = new Category();
            $category->setName(filter_input(INPUT_POST, 'name'));
            $category->setSubtitle(filter_input(INPUT_POST, 'subtitle'));
            $category->setPicture(filter_input(INPUT_POST, 'picture'));


            // Je charge ma vue
            $this->show('category/create-update', [
                // Je partage à ma vue ma category
                'category' => $category,
                // Je partage à ma vue la liste des erreurs
                'errorList' => $errorList,
                'mode' => $mode
            ]);
        }
    }
}