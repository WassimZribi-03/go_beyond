<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Models/Tour.php');

class TourController
{
    // List all tours
    public function listTours()
    {
        $sql = "SELECT * FROM tours";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Show a specific tour by ID
    public function showTour($id)
    {
        $sql = "SELECT * FROM tours WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
            return $req->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add a new tour
    public function addTour($tour)
    {
        $sql = "INSERT INTO tours (name, destination, duration, price, description) 
                VALUES (:name, :destination, :duration, :price, :description)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'name' => $tour->getName(),
                'destination' => $tour->getDestination(),
                'duration' => $tour->getDuration(),
                'price' => $tour->getPrice(),
                'description' => $tour->getDescription(),
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Delete a tour by ID
    public function deleteTour($id)
    {
        $sql = "DELETE FROM tours WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Update a tour
    public function updateTour($tour, $id)
    {
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE tours SET 
                    name = :name,
                    destination = :destination,
                    duration = :duration,
                    price = :price,
                    description = :description
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
                'name' => $tour->getName(),
                'destination' => $tour->getDestination(),
                'duration' => $tour->getDuration(),
                'price' => $tour->getPrice(),
                'description' => $tour->getDescription(),
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); 
        }
    }
}
?>
