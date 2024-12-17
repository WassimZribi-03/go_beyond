<?php
include(__DIR__ . '/../config.php');
include(__DIR__ . '/../Models/Tour.php');

class TourController
{
    private $db;

    public function __construct() {
        try {
            $this->db = config::getConnexion();
        } catch (Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }

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
        try {
            $query = "SELECT * FROM tours";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error listing tours: " . $e->getMessage());
            return [];
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
    public function addTour($tour, $image = null) {
        try {
            if ($image && $image['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/assets/images/tours/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = uniqid() . '_' . basename($image['name']);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
                    $tour->setImageUrl('assets/images/tours/' . $fileName);
                }
            }

            $db = config::getConnexion();
            $query = $db->prepare(
                'INSERT INTO tours (name, destination, duration, price, description, image_url) 
                 VALUES (:name, :destination, :duration, :price, :description, :image_url)'
            );

            $query->execute([
                'name' => $tour->getName(),
                'destination' => $tour->getDestination(),
                'duration' => $tour->getDuration(),
                'price' => $tour->getPrice(),
                'description' => $tour->getDescription(),
                'image_url' => $tour->getImageUrl()
            ]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Error adding tour: " . $e->getMessage());
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

    // Enhanced tour filtering with ratings and favorites
    public function getFilteredTours($destination = '', $min_price = '', $max_price = '', $duration = '', $name = '') {
        try {
            $sql = "SELECT * FROM tours WHERE 1=1";
            $params = [];

            if (!empty($name)) {
                $sql .= " AND name LIKE ?";
                $params[] = "%$name%";
            }

            if (!empty($destination)) {
                $sql .= " AND destination LIKE ?";
                $params[] = "%$destination%";
            }

            if (!empty($min_price)) {
                $sql .= " AND price >= ?";
                $params[] = $min_price;
            }

            if (!empty($max_price)) {
                $sql .= " AND price <= ?";
                $params[] = $max_price;
            }

            if (!empty($duration)) {
                $sql .= " AND duration = ?";
                $params[] = $duration;
            }

            $sql .= " ORDER BY name ASC";

            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error filtering tours: " . $e->getMessage());
            return [];
        }
    }

    // Rating system methods
    public function addRating($tour_id, $rating, $comment = null) {
        try {
            $query = $this->db->prepare("
                INSERT INTO ratings (tour_id, rating, comment) 
                VALUES (?, ?, ?)
            ");
            return $query->execute([$tour_id, $rating, $comment]);
        } catch (PDOException $e) {
            error_log("Error adding rating: " . $e->getMessage());
            return false;
        }
    }

    public function getAverageRating($tour_id) {
        try {
            $query = $this->db->prepare("
                SELECT AVG(rating) as avg_rating, COUNT(*) as count 
                FROM ratings 
                WHERE tour_id = ?
            ");
            $query->execute([$tour_id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return [
                'average' => round($result['avg_rating'] ?? 0, 1),
                'count' => $result['count'] ?? 0
            ];
        } catch (PDOException $e) {
            error_log("Error getting average rating: " . $e->getMessage());
            return ['average' => 0, 'count' => 0];
        }
    }

    // Favorite functionality
    public function isFavorited($tour_id) {
        try {
            $query = $this->db->prepare("SELECT COUNT(*) FROM favorites WHERE tour_id = ?");
            $query->execute([$tour_id]);
            return $query->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error checking favorite status: " . $e->getMessage());
            return false;
        }
    }

    public function addToFavorites($tour_id) {
        try {
            if ($this->isFavorited($tour_id)) {
                // Remove from favorites
                $query = $this->db->prepare("DELETE FROM favorites WHERE tour_id = ?");
                $result = $query->execute([$tour_id]);
                return ['success' => $result, 'action' => 'removed'];
            } else {
                // Add to favorites
                $query = $this->db->prepare("INSERT INTO favorites (tour_id) VALUES (?)");
                $result = $query->execute([$tour_id]);
                return ['success' => $result, 'action' => 'added'];
            }
        } catch (PDOException $e) {
            error_log("Error toggling favorite: " . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
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

    // Get total number of tours
    public function getTotalTours()
    {
        try {
            $db = config::getConnexion();
            $query = $db->query("SELECT COUNT(*) FROM tours");
            return $query->fetchColumn();
        } catch (Exception $e) {
            error_log("Error getting total tours: " . $e->getMessage());
            return 0;
        }
    }
}
?>
