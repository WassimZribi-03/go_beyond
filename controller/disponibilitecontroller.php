<?php
include(__DIR__ . '/../config.php');
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
                (id,id_guide, available_date, start_time, end_time, status) 
                VALUES 
                (NULL,:id_guide, :available_date, :start_time, :end_time, :status)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_guide' => $disponibility->getIdGuide(),
                'available_date' => $disponibility->getAvailableDate()->format('Y-m-d'),
                'start_time' => $disponibility->getStartTime(),
                'end_time' => $disponibility->getEndTime(),
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
                'start_time' => $disponibility->getStartTime(),
                'end_time' => $disponibility->getEndTime(),
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
}
?>
