<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Brand extends CoreModel {
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table

    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $footer_order;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Brand en fonction d'un id donné
     *
     * @param int $brandId ID de la marque
     * @return Brand
     */
    public static function find($brandId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = '
            SELECT *
            FROM brand
            WHERE id = ' . $brandId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $brand = $pdoStatement->fetchObject('App\Models\Brand');

        // retourner le résultat
        return $brand;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table brand
     *
     * @return Brand[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `brand`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Brand');

        return $results;
    }

    /**
     * Récupérer les 5 marques mises en avant dans le footer
     *
     * @return Brand[]
     */
    public static function findAllFooter()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM brand
            WHERE footer_order > 0
            ORDER BY footer_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $brands = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Brand');

        return $brands;
    }

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table brand
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    protected function insert()
    {

        $pdo = Database::getPDO();
        $sql = " 
        INSERT INTO brand
        (`name`)
        VALUES (:name);
        ";

        // Préparation de la requete sql
        $pdoStatement = $pdo->prepare($sql);

        // J'indique à pdoStatement la correspondance entre mes :truc et la bonne valeur
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        
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
        UPDATE brand
        SET `name` = :name, `updated_at` = now()
        WHERE id = :id;
        ";

        // Préparation de la requete sql
        $pdoStatement = $pdo->prepare($sql);

        // J'indique à pdoStatement la correspondance entre mes :truc et la bonne valeur
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
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
        DELETE FROM brand
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
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of footer_order
     *
     * @return  int
     */
    public function getFooterOrder()
    {
        return $this->footer_order;
    }

    /**
     * Set the value of footer_order
     *
     * @param  int  $footer_order
     */
    public function setFooterOrder(int $footer_order)
    {
        $this->footer_order = $footer_order;
    }
}
