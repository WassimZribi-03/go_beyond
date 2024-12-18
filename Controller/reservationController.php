<?php
include_once(__DIR__ . '/../config.php');
include_once(__DIR__ . '/../Model/Reservation.php');

class ReservationController
{
    public function listReservations()
    {
        $sql = "SELECT * FROM reservations";
        $db = config::getConnexion();
        try {
            return $db->query($sql)->fetchAll();
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    public function addReservation($reservation)
    {
        $sql = "INSERT INTO reservations 
                VALUES (NULL,:user_id, :guide_id, :disponibility_id)";
        $sqlUpdate = "UPDATE disponibilites_guides SET status = 0 WHERE id = :disponibility_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'user_id' => $reservation->getUserId(),
                'guide_id' => $reservation->getGuideId(),
                'disponibility_id' => $reservation->getDisponibilityId(),
                
            ]);
            $updateQuery = $db->prepare($sqlUpdate);
            $updateQuery->execute([
                'disponibility_id' => $reservation->getDisponibilityId(),
            ]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function showReservation($id)
    {
        $sql = "SELECT * FROM reservations WHERE id = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
