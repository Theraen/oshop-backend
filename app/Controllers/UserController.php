<?php

namespace App\Controllers;

use App\Models\AppUser;

class userController extends CoreController
{

    /**
     * Methode s'occupant d'afficher le formulaire de connexion
     *
     */

    public function login()
    {

        $_SESSION['token'] = bin2hex(random_bytes(32));

        $this->show('user/login');
    }

    public function list() {

        $_SESSION['token'] = bin2hex(random_bytes(32));

        $allUsers = AppUser::findAll();

        $this->show('user/list', [
            'allUsers' => $allUsers
        ]);
    }

     /**
     * Méthode s'occupant d'afficher le formulaire d'ajout d'un nouvelle utilisateur
     *
     * Méthode HTTP: GET
     *
     * @return void
     */
    public function add()
    {

        $_SESSION['token'] = bin2hex(random_bytes(32));

        $this->show('user/create-update', [
            'mode' => 'create'
        ]);
    }

        /**
     * Méthode qui permet d'afficher le formulaire de modification d'une catégorie
     *
     * Méthode HTTP: GET
     *
     * @return void
     */
    public function update($user_id)
    {
        
        $_SESSION['token'] = bin2hex(random_bytes(32));
        // Je cherche à récuperer la catégorie que l'on souhaite modifier
        $user = AppUser::find($user_id);

        // En premier lieu, je vérifie si elle existe bien !
        if (empty($user)) {

            // On envoie le header 404
            header('HTTP/1.0 404 Not Found');

            // Puis on gère l'affichage
            return $this->show('error/err404');
        }

            // A partir de maintenant, je sais que ma catégorie existe bien..

            $this->show('user/create-update', [
                'user' => $user,
                'mode' => 'update'
            ]);
        }

        public function delete($user_id) {

            

            $user = AppUser::find($user_id);
    
            $deleted = $user->delete();
               
    
                // Si tous c'est bien passé
                if($deleted) {
                    // On va dire à notre serveur WEB de dire au navigateur WEB d'aller sur une autre URL
                    // C'est le principe de la "redirection"
    
                    // Pour ce faire il faut que le serveur WEB envoi en réponse de la requete HTTP
                    // Un header de type "Location:"
    
                    // un peu crade mais necessaire ici
                    global $router;
    
                    // A partir de là je vais indiquer à mon navigateur d'aller sur cette URL là.
                    header('Location: ' . $router->generate('user-list'));
    
                    // j'arrête l'execution de ma méthode là.
                    return;
                }
                // Si au contraire il y a eu un soucis
                else {
                    // on ajoute un message d'erreur
                    $errorList[] = 'La suppresion a échoué, merci de retenter';
                }
    
          }


        /**
     * Méthode s'occupant de traiter l'ajout d'un nouveau produit
     *
     * Méthode HTTP: POST
     *
     * @return void
     */
    public function createEdit($user_id = null)
    {

        

        // Si on ne m'a pas fourni d'id de produit
        if (is_null($user_id)) {

            // C'est qu'on souhaite créer le produit
            $mode = 'create';

        // Sinon...
        } else {

            // C'est qu'on souhaite modifier un produit !
            $mode = 'update';

            // Je récupere le produit dont l'id est passé dans l'url
            $user = AppUser::find($user_id);

            // SI le produit n'existe pas en base...
            if (empty($user)) {

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
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);


        //On va vérifier si les champs du formulaire sont bien renseignée
        $errorList = [];
        $regex = '/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\&\~\#\-\|\_\@\°\$\£\^\%\*\?\;\/\!\§]).{8,}/';

        // Validation de l'email
        if (empty($email)) {
            $errorList[] = 'L\'email est vide';
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errorList[] = 'Le champ Email doit être dans un format valide d\'adresse mail : etudiant@oclock.io';
        }

        if (empty($password)) {
            $errorList[] = 'Le mot de passe est vide';
        }
        if ($password === false) {
            $errorList[] = 'Le mot de passe est invalide';
        }

        if (preg_match($regex, $password) == '0' || preg_match($regex, $password) == false) {
            $errorList[] = 'Le mot de passe doit contenir Au moins 8 caractères, dont moins une majuscule, une minuscule, un chiffre et un caractère spécial';
        }

        if ($firstname === false) {
            $errorList[] = 'Le prénom est invalide';
        }
        // Etc.
        if ($lastname === false) {
            $errorList[] = 'Le nom est invalide';
        }
        if(empty($role)) {

            $errorList[] = 'Merci de selectionner un rôle';
        }

        if (!in_array($role, ['admin', 'catalog-manager'])) {

            $errorList[] = 'Rôle inconnu';
        }

        if(empty($status)) {

            $errorList[] = 'Merci de selectionner un status';
        }

        if (!in_array($status, ['1', '2'])) {

            $errorList[] = 'Status inconnu';
        }


        // TODO continuer les controlles si besoin...



        // Si il n'y a pas d'erreurs dans mon tableau qui les listes...

        if (empty($errorList)) {


            // En mode de création, on souhaite créé un nouveau user
            if ($mode == 'create') {

                // On instancie donc un nouveau modèle (vide) de type Product.
                $user = new AppUser();
            }

            // Si je ne suis pas en mode de création, c'est que j'ai déjà une instance
            // du produit que je souhaite modifier.

            // On met à jour les propriétés de l'instance.
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            $user->setRole($role);
            $user->setStatus($status);


            $queryExecuted = $user->save();

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
                    header('Location: '.$router->generate('user-list'));

                } else {

                    // A partir là je vais indiquer à mon navigateur d'aller sur cette URL là
                    header('Location: '.$router->generate('user-update', ['idUser' => $user->getId()]));
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
            $user = new AppUser();
            $user->setEmail(filter_input(INPUT_POST, 'email'));
            $user->setFirstname(filter_input(INPUT_POST, 'firstname'));
            $user->setLastname(filter_input(INPUT_POST, 'lastname'));
            $user->setStatus(filter_input(INPUT_POST, 'status'));
            $user->setRole(filter_input(INPUT_POST, 'role'));
            $user->setStatus(filter_input(INPUT_POST, 'status'));


            // Je charge ma vue
            $this->show('user/create-update', [
                // Je partage à ma vue ma category
                'user' => $user,
                // Je partage à ma vue la liste des erreurs
                'errorList' => $errorList,
                'mode' => $mode
            ]);
        }
    }

    public function checkLogin() {

        // On tente de récuperer les données venant du formulaire
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        //On va vérifier si les champs du formulaire sont bien renseignée
        $errorList = [];

        

        // On verifie si les champs du formulaire sont bien renseignée
        if(empty($email)) {
            $errorList[] = 'Le champ email est requis !';
        }

        if(empty($password)) {
            $errorList[] = 'Le champ mot de passe est requis !';
        }

        global $router;

        // Si il n'y a pas d'erreur pour le moment ...
        if(empty($errorList)) {
            $user = AppUser::findByEmail($email);
            if($user === false) {
                $errorList[] = 'Utilisateur ou mot de passe incorrect';
                // La je sais que mon utilisateur est bien présent en base de donnée
            } else {
                // Je compare le mot de passe de l'utilisateur en base avec le mdp saisie dans le formulaire
                 if(!password_verify($password, $user->getPassword())) {
                    $errorList[] = 'Utilisateur ou mot de passe incorrect';
                 // Si les mdp correspondent
                } else {
                    $_SESSION['connectedUser'] = $user->getId();
                    header('Location: '. $router->generate('main-home'));
                }
            }
        } 

            $login = new AppUser();
            $login->setEmail(filter_input(INPUT_POST, 'email'));

            // Je charge ma vue
            $this->show('user/login', [
            // Je partage à ma vue ma category
            'login' => $login,
            // Je partage à ma vue la liste des erreurs
            'errorList' => $errorList
            ]);

    }

    public function logout() {

        

        // Je supprime la clé "connectedUser" présente en session
        // qui symbole le fait qu'un utilisateur est connecté sur mon site
        unset($_SESSION['connectedUser']);

        global $router;

        header('Location: '.$router->generate('user-login'));
    }
} 
