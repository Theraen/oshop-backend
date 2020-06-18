<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{
    private $email;

    private $password;

    private $firstname;

    private $lastname;

    private $role;

    private $status;


    /**
     * Méthode permettant de récupérer un enregistrement de la table appUser en fonction d'un id donné
     *
     * @param int $id ID de l'utilisateur
     * @return AppUser
     */
    public static function find($id)
    {
 
        // se connecter à la BDD
        $pdo = Database::getPDO();
 
        // écrire notre requête
        $sql = "SELECT * FROM `app_user` WHERE `id` = :id";
        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id', $id, PDO::PARAM_STR);

        $pdoStatement->execute();
        
        $result = $pdoStatement->fetchObject(self::class);
 
        return $result;
    }

        /**
     * Méthode permettant de récupérer un enregistrement de la table appUser en fonction d'un email donné
     *
     * @param string $email email de l'utilisateur
     * @return AppUser
     */
    public static function findByEmail($email)
    {
 
        // se connecter à la BDD
        $pdo = Database::getPDO();
 
        // écrire notre requête
        $sql = "SELECT * FROM `app_user` WHERE `email` = :email";
        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);

        $pdoStatement->execute();

        $result = $pdoStatement->fetchObject(self::class);
 
        return $result;

    }


    /**
     * Méthode permettant de récupérer tous les enregistrements de la table brand
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table appUser
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    protected function insert()
    {

        $pdo = Database::getPDO();
        $sql = " 
        INSERT INTO app_user
        (`email`, `password`, `firstname`, `lastname`, `role`, `status`)
        VALUES (:email, :password, :firstname, :lastname, :role, :status);
        ";

        // Préparation de la requete sql
        $pdoStatement = $pdo->prepare($sql);

        // J'indique à pdoStatement la correspondance entre mes :truc et la bonne valeur
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);

        // Est ce que ma requete c'est bien executée
        $executed = $pdoStatement->execute();

        $insertedRows = $pdoStatement->rowCount();                                        

        if ($executed && $insertedRows === 1) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
        
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table brand
     * L'objet courant doit contenir l'id, et toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    protected function update()
    {

        $pdo = Database::getPDO();
        $sql = " 
        UPDATE app_user
        SET 
        `email` = :email,
        `password` = :password,
        `firstname` = :firstname,
        `lastname` = :lastname,
        `role` = :role,
        `status` = :status,
        `updated_at` = now()
        WHERE id = :id;
        ";

        // Préparation de la requete sql
        $pdoStatement = $pdo->prepare($sql);

        // J'indique à pdoStatement la correspondance entre mes :truc et la bonne valeur
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        
        // Est ce que ma requete c'est bien executée
        $executed = $pdoStatement->execute();

        $updatedRows = $pdoStatement->rowCount();                                        

        if ($executed && $updatedRows === 1) {

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
        
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
        
    }

    public function delete() {

        $pdo = Database::getPDO();
        $sql = " 
        DELETE FROM app_user
        WHERE id = :id;
        ";

        // Préparation de la requete sql
        $pdoStatement = $pdo->prepare($sql);

        // J'indique à pdoStatement la correspondance entre mes :truc et la bonne valeur
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
                
        // Est ce que ma requete c'est bien executée
        $executed = $pdoStatement->execute();
        
        $deletedRows = $pdoStatement->rowCount();                                        
        
        if ($executed && $deletedRows === 1) {
        
            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }
                
        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;

    }


    /**
     * Get the value of email
     *
     * @return  string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param   string  $email  
     *
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param   string  $password  
     *
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param   string  $firstname  
     *
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param   string  $lastname  
     *
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param   string  $role  
     *
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param   int  $status  
     *
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}