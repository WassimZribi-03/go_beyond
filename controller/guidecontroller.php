<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/guide.php');

class GuideTouristiqueController
{
    public function listGuides()
    {
        $sql = "SELECT * FROM guide ";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function deleteGuide($id)
    {
        $sql = "DELETE FROM guide WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addGuide($guide)
    {
        $db = config::getConnexion();
        $sql = "INSERT INTO guide
        VALUES (
            NULL, 
            :title, :description, :language, 
            :price, :category, :region, 
            :city, :country
        )";
      
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'title' => $guide->getTitle(),
                'description' => $guide->getDescription(),
                'language' => $guide->getLanguage(),
                'price' => $guide->getPrice(),
                'category' => $guide->getCategory(),
                'region' => $guide->getRegion(),
                'city' => $guide->getCity(),
                'country' => $guide->getCountry(),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateGuide($guide, $id)
    {
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE guide SET 
                    title = :title,
                    description = :description,
                    language = :language,
                    price = :price,
                    category = :category,
                    region = :region,
                    city = :city,
                    country = :country,
                WHERE id = :id'
            );
           

            $query->execute([
                'id' => $id,
                'title' => $guide->getTitle(),
                'description' => $guide->getDescription(),
                'language' => $guide->getLanguage(),
                'price' => $guide->getPrice(),
                'category' => $guide->getCategory(),
                'region' => $guide->getRegion(),
                'city' => $guide->getCity(),
                'country' => $guide->getCountry(),
              
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function showGuide($id)
    {
        $sql = "SELECT * FROM guide WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $guide = $query->fetch();
            return $guide;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
