<?php
if (!class_exists('Tour')) {
    class Tour {
        private ?int $id;
        private ?string $name;
        private ?string $destination;
        private ?int $duration;
        private ?float $price;
        private ?string $description;
        private ?string $image_url;
        private $db;

        public function __construct(
            ?int $id = null, 
            ?string $name = null, 
            ?string $destination = null, 
            ?int $duration = null, 
            ?float $price = null, 
            ?string $description = null, 
            ?string $image_url = null
        ) {
            $this->id = $id;
            $this->name = $name;
            $this->destination = $destination;
            $this->duration = $duration;
            $this->price = $price;
            $this->description = $description;
            $this->image_url = $image_url;
            $this->db = config::getConnexion();
        }

        // Getters and Setters
        public function getId(): ?int {
            return $this->id;
        }

        public function setId(?int $id): void {
            $this->id = $id;
        }

        public function getName(): ?string {
            return $this->name;
        }

        public function setName(?string $name): void {
            $this->name = $name;
        }

        public function getDestination(): ?string {
            return $this->destination;
        }

        public function setDestination(?string $destination): void {
            $this->destination = $destination;
        }

        public function getDuration(): ?int {
            return $this->duration;
        }

        public function setDuration(?int $duration): void {
            $this->duration = $duration;
        }

        public function getPrice(): ?float {
            return $this->price;
        }

        public function setPrice(?float $price): void {
            $this->price = $price;
        }

        public function getDescription(): ?string {
            return $this->description;
        }

        public function setDescription(?string $description): void {
            $this->description = $description;
        }

        public function getImageUrl(): ?string {
            return $this->image_url;
        }

        public function setImageUrl(?string $image_url): void {
            $this->image_url = $image_url;
        }

        public function getTourById($id) {
            try {
                $query = "SELECT * FROM tours WHERE id = :id";
                $stmt = $this->db->prepare($query);
                $stmt->execute(['id' => $id]);
                return $stmt->fetch();
            } catch (Exception $e) {
                throw $e;
            }
        }

        public function getDb() {
            return $this->db;
        }
    }
}
?>
