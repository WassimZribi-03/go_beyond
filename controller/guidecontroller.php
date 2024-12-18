<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/guide.php');

class GuideTouristiqueController
{
    public function listGuides($searchName = '', $searchLanguage = '', $searchRegion = '')
{
   
    $sql = "SELECT * FROM guide WHERE 1";

    $bindParams = [];

  
    if (!empty($searchName)) {
        $sql .= " AND LOWER(title) LIKE :searchName";
        $bindParams[':searchName'] = '%' . strtolower($searchName) . '%';
    }

    if (!empty($searchLanguage)) {
        $sql .= " AND LOWER(language) LIKE :searchLanguage";
        $bindParams[':searchLanguage'] = '%' . strtolower($searchLanguage) . '%';
    }

    if (!empty($searchRegion)) {
        $sql .= " AND LOWER(region) LIKE :searchRegion";
        $bindParams[':searchRegion'] = '%' . strtolower($searchRegion) . '%';
    }

   
    $db = config::getConnexion();
    try {
        $stmt = $db->prepare($sql);
        
      
        foreach ($bindParams as $param => $value) {
            $stmt->bindValue($param, $value);
        }

        $stmt->execute();
        
       
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
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
            :country
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
    
            // Fixing the SQL query: Removed the extra comma after 'country'
            $query = $db->prepare(
                'UPDATE guide SET 
                    title = :title,
                    description = :description,
                    language = :language,
                    price = :price,
                    category = :category,
                    region = :region,
                    country = :country
                WHERE id = :id'
            );
    
            // Execute the query with the proper parameter bindings
            $query->execute([
                'id' => $id,
                'title' => $guide->getTitle(),
                'description' => $guide->getDescription(),
                'language' => $guide->getLanguage(),
                'price' => $guide->getPrice(),
                'category' => $guide->getCategory(),
                'region' => $guide->getRegion(),
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
