<?php

namespace App\Controllers;

use App\Models\AppUser;

abstract class CoreController {


    public function __construct() {

        // Là je vais pouvoir automatiser l'execution du checkAuthorization.

        // Mais il est neccessaire que je connaisse ici, les rôles à autoriser.

        // Pour cela, je doit réaliser un listing ... Autrement dit : un ACL.

        // La variabler $match contient les infos sur la route courante.
        global $match;

        // On récupère le nom de la route courante
        $routeName = $match['name'];

        $acl = [
            'main-home' => ['admin', 'catalog-manager'],
            'category-list' => ['admin', 'catalog-manager'],
            'category-add' => ['admin', 'catalog-manager'],
            'category-add-post' => ['admin', 'catalog-manager'],
            'category-update' => ['admin', 'catalog-manager'],
            'category-update-post' => ['admin', 'catalog-manager'],
            'category-delete' => ['admin', 'catalog-manager'],
            'product-list' => ['admin', 'catalog-manager'],
            'product-add' => ['admin', 'catalog-manager'],
            'product-add-post' => ['admin', 'catalog-manager'],
            'product-update' => ['admin', 'catalog-manager'],
            'product-update-post' => ['admin', 'catalog-manager'],
            'product-delete' => ['admin', 'catalog-manager'],
            'type-list' => ['admin', 'catalog-manager'],
            'type-add' => ['admin', 'catalog-manager'],
            'type-add-post' => ['admin', 'catalog-manager'],
            'type-update' => ['admin', 'catalog-manager'],
            'type-update-post' => ['admin', 'catalog-manager'],
            'type-delete' => ['admin', 'catalog-manager'],
            'brand-list' => ['admin', 'catalog-manager'],
            'brand-add' => ['admin', 'catalog-manager'],
            'brand-add-post' => ['admin', 'catalog-manager'],
            'brand-update' => ['admin', 'catalog-manager'],
            'brand-update-post' => ['admin', 'catalog-manager'],
            'brand-delete' => ['admin', 'catalog-manager'],
            //'user-login' => [''],
            //'user-login-post' => [''],
            'user-logout' => ['admin', 'catalog-manager'],
            'user-list' => ['admin'],
            'user-add' => ['admin'],
            'user-add-post' => ['admin'],
            'user-delete'  => ['admin']
        ];

        // Je commence par vérifier si la route à un acl de défini
        if(array_key_exists($routeName, $acl)) {

            //Si c 'est le cas je récupềre la liste des rôles associé
            $authorizedRolesList = $acl[$routeName];

             // Puis on utilise la méthode checkAuthorization pour vérifier...
             $this->checkAuthorization($authorizedRolesList);
            }
            // Sinon ba... on ne fait rien ! La route est libre :)

            $this->checkCSRF($routeName);

    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewVars Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewVars = []) {

         // J'ajoute une clé isConnected pour mes vues
        // Celle-ci va contenir un booléan qui sera à true si l'utilisateur est bien connecté
        // Pour cela, je me base sur la clé 'connectedUser' présente en session
        $viewVars['isConnected'] = isset($_SESSION['connectedUser']) ? true : false;
        $viewVars['isAdmin'] = false;
        $viewVars['connectedUser'] = null;

        // Si l'utilisateur est connecté
        if ($viewVars['isConnected']) {

            // Alors on récupère l'utilisateur connecté
            $user = AppUser::find($_SESSION['connectedUser']);

            $viewVars['connectedUser'] = $user;

            // Todo, vérifier que l'utilisateur existe toujours en BDD

            // Puis on récupère son rôle
            $viewVars['isAdmin'] = $user->getRole() == 'admin' ? true : false;
        }

        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewVars est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewVars['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewVars, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewVars);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewVars est disponible dans chaque fichier de vue
        require_once __DIR__.'/../views/layout/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/layout/footer.tpl.php';
    }

    /**
     * Méthode qui va vérifier si l'utilisateur authentifié à bien le bon role
     *
     * @param array $authorizedRolesList
     * @return bool
     */
    public function checkAuthorization($authorizedRolesList=[]) {
        
        // Si l'utilisateur est connecté
        if(isset($_SESSION['connectedUser'])) {

            // Alors on récupère l'utilisateur connecté
            $user = AppUser::find($_SESSION['connectedUser']);

            // Puis on récupère son rôle
            $userRole = $user->getRole();

            // Si le rôle de l'utilisateur fait partie des rôles autorisdés (fournis en paramètres ($roles))
            if(in_array($userRole, $authorizedRolesList)) {
                // Alors on return true
                return true;

                // Sinon c'est que l'utilisateur courant n'a pas la permission d'accés à la page
            } else {
                
                // => On envoi le header "403 Forbidden"
                header('HTTP/1.0 403 Forbidden');
                // Puis on affiche la page d'erreur (le template) erreur 403
                $this->show('error/err403');
                // Pour finir, on arrête le script pour que la page demandée ne s'affiche pas.
                die();
            }
        // Sinon, si l'utilisateur n'est pas connecté à un compte
        } else {
            // Alors on le redirige vers la page de connexion
            global $router;

            header('Location: '.$router->generate('user-login'));

        }
        

    }

    public function checkCSRF($routeName) {

        $csrfTokenCheckInPost = [
            'user-add-post',
            'user-update-post',
            'category-add-post',
            'category-update-post',
            'category-update-home-post',
            'product-add-post',
            'product-update-post',
            'type-add-post',
            'type-update-post',
            'brand-add-post',
            'brand-update-post',
            'user-login-post'

        ];

        $csrfTokenCheckInGet = [
            'category-delete',
            'product-delete',
            'type-delete',
            'brand-delete',
            'user-delete'
        ];

        // Si ma route actuelle necessite la verif d'un token CSRF
        if(in_array($routeName, $csrfTokenCheckInPost)) {

            // On récupère le token envoyé en POST
            $token = isset($_POST['token']) ? $_POST['token'] : NULL;

            // On récupère le token en session
            $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : NULL;

            if($token !== $sessionToken) {

                header('HTTP/1.0 403 Forbidden');

                $this->show('error/err403');

                die();
            } else {

                // on supprime le token en session
                // Ainsi, on ne pourras pas soumettre le même formulaire plusieurs fois ni même réutiliser le token.
                unset($_SESSION['token']);
            }
        } elseif(in_array($routeName, $csrfTokenCheckInGet)) {

            $token = isset($_GET['token']) ? $_GET['token'] : NULL;

            $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : NULL;

            if($token !== $sessionToken) {
                header('HTTP/1.0 403 Forbidden');

                $this->show('error/err403');

                die();
            } else {

                // on supprime le token en session
                // Ainsi, on ne pourras pas soumettre le même formulaire plusieurs fois ni même réutiliser le token.
                unset($_SESSION['token']);
            }

        }
    }
}
