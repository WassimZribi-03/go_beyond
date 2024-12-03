<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Models/Tour.php');

class TourController
{
    // List all tours with booking count
    public function listToursWithBookings()
    {
        try {
            $db = config::getConnexion();
            
            $query = $db->prepare("
                SELECT 
                    tours.*,
                    COUNT(bookings.id) as booking_count
                FROM tours
                LEFT JOIN bookings ON tours.id = bookings.tour_id
                GROUP BY tours.id
                ORDER BY tours.name ASC
            ");

            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

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
        try {
            $db = config::getConnexion();
            
            // First, delete all bookings associated with this tour
            $deleteBookingsQuery = $db->prepare('DELETE FROM bookings WHERE tour_id = :id');
            $deleteBookingsQuery->execute(['id' => $id]);
            
            // Then delete the tour
            $deleteTourQuery = $db->prepare('DELETE FROM tours WHERE id = :id');
            $deleteTourQuery->execute(['id' => $id]);
            
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
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

    public function getFilteredTours($destination = '', $minPrice = '', $maxPrice = '', $duration = '') {
        try {
            $db = config::getConnexion();
            $query = "SELECT * FROM tours WHERE 1=1";
            $params = [];

            if (!empty($destination)) {
                $query .= " AND destination LIKE :destination";
                $params['destination'] = "%$destination%";
            }

            if (!empty($minPrice)) {
                $query .= " AND price >= :min_price";
                $params['min_price'] = $minPrice;
            }

            if (!empty($maxPrice)) {
                $query .= " AND price <= :max_price";
                $params['max_price'] = $maxPrice;
            }

            if (!empty($duration)) {
                $query .= " AND duration = :duration";
                $params['duration'] = $duration;
            }

            $stmt = $db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Filter error: " . $e->getMessage());
            return [];
        }
    }

    public function getTourById($id) {
        try {
            $db = config::getConnexion();
            $query = "SELECT * FROM tours WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $tour = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$tour) {
                throw new Exception("Tour not found");
            }
            
            return $tour;
        } catch (Exception $e) {
            throw new Exception("Error fetching tour: " . $e->getMessage());
        }
    }
}
?>
