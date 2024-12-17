<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../model/event.php');

class EventController
{
    public function listEvents()
{
    $sql = "SELECT * FROM gestionevent";
    $db = config::getConnexion();
    try {
        $liste = $db->query($sql);
        // Fetch all results as an associative array
        return $liste;
    } catch (Exception $e) {
        die('Error:' . $e->getMessage());
    }
}

    function deleteEvent($id)
    {
        $sql = "DELETE FROM gestionevent WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    function addEvent($event)
    {
        $sql = "INSERT INTO gestionevent
        VALUES (
            NULL, 
            :title, :description, :date_start, 
            :place, :price, :capacity
        )";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'date_start' => $event->getDateStart(),
                'place' => $event->getPlace(),
                'price' => $event->getPrice(),
                'capacity' => $event->getCapacity()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function updateEvent($event, $id)
    {
        try {
            $db = config::getConnexion();

            $query = $db->prepare(
                'UPDATE gestionevent SET 
                    title = :title,
                    description = :description,
                    date_start = :date_start,
                    place = :place,
                    price = :price,
                    capacity = :capacity
                WHERE id = :id'
            );

            $query->execute([
                'id' => $id,
                'title' => $event->getTitle(),
                'description' => $event->getDescription(),
                'date_start' => $event->getDateStart(),
                'place' => $event->getPlace(),
                'price' => $event->getPrice(),
                'capacity' => $event->getCapacity()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function showEvent($id)
    {
        $sql = "SELECT * FROM gestionevent WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $event = $query->fetch();
            return $event;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}

