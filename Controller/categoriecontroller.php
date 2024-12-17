<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../model/categorievent.php');

class CategorieventController
{
    public function listcategories()
    {
        $sql = "SELECT * FROM categorievent";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            // Fetch all results as an associative array
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function deletecategorie($id_categ)
    {
        $sql = "DELETE FROM categorievent WHERE id_categ = :id_categ";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_categ', $id_categ);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function addcategorie($categorie)
    {
        $sql = "INSERT INTO categorievent
        VALUES (
            NULL, 
            :categorie, :disponibilite, :organisateur
        )";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'categorie' => $categorie->getCategorie(),
                'disponibilite' => $categorie->getDisponibilite(),
                'organisateur' => $categorie->getOrganisateur()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updatecategorie($categorie, $id_categ)
    {
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE categorievent SET 
                    categorie = :categorie,
                    disponibilite = :disponibilite,
                    organisateur = :organisateur
                WHERE id_categ = :id_categ'
            );

            $query->execute([
                'id_categ' => $id_categ,
                'categorie' => $categorie->getCategorie(),
                'disponibilite' => $categorie->getDisponibilite(),
                'organisateur' => $categorie->getOrganisateur()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function showcategorie($id_categ)
    {
        $sql = "SELECT * FROM categorievent WHERE id_categ = :id_categ";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id_categ', $id_categ, PDO::PARAM_INT);
            $query->execute();

            $categorie = $query->fetch();
            return $categorie;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}


















