<?php
include_once(__DIR__ . '/../config.php');
include(__DIR__ . '/../Model/disponibilite.php');
class DisponibilitesGuidesController
{
    public function listDisponibilities()
    {
        $sql = "SELECT * FROM disponibilites_guides";
        $db = config::getConnexion();
        try {
            $list = $db->query($sql);
            return $list;
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function addDisponibility($disponibility)
    {
        $sql = "INSERT INTO disponibilites_guides 
                (id, available_date, start_time, end_time, id_guide ,status) 
                VALUES 
                (NULL, :available_date, :start_time, :end_time,:id_guide, :status)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'available_date' => $disponibility->getAvailableDate()->format('Y-m-d'),
                'start_time' => $disponibility->getStartTime()->format('H:i:s'),
                'end_time' => $disponibility->getEndTime()->format('H:i:s'),
                'id_guide' => $disponibility->getIdGuide(),
                'status' => $disponibility->getStatus()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function updateDisponibility($disponibility, $id)
    {
        $sql = "UPDATE disponibilites_guides SET 
                    id_guide = :id_guide,
                    available_date = :available_date,
                    start_time = :start_time,
                    end_time = :end_time,
                    status = :status
                WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                'id_guide' => $disponibility->getIdGuide(),
                'available_date' => $disponibility->getAvailableDate()->format('Y-m-d'),
                'start_time' => $disponibility->getStartTime()->format('H:i:s'),
                'end_time' => $disponibility->getEndTime()->format('H:i:s'),
                'status' => $disponibility->getStatus()
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteDisponibility($id)
    {
        $sql = "DELETE FROM disponibilites_guides WHERE id = :id";
        $db = config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function showDisponibility($id)
    {
        $sql = "SELECT * FROM disponibilites_guides WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $disponibility = $query->fetch();
            return $disponibility;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }


    public function listDisponibilitiesByGuide($id_guide)
    {
        $sql = "SELECT * FROM disponibilites_guides WHERE id_guide = :id_guide  AND status = 1 ";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id_guide', $id_guide, PDO::PARAM_INT);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
