<?php
if (!class_exists('Tour')) {
    class Tour {
        private ?int $id;
        private ?string $name;
        private ?string $destination;
        private ?int $duration;
        private ?float $price;
        private ?string $description;

        public function __construct(?int $id, ?string $name, ?string $destination, ?int $duration, ?float $price, ?string $description) {
            $this->id = $id;
            $this->name = $name;
            $this->destination = $destination;
            $this->duration = $duration;
            $this->price = $price;
            $this->description = $description;
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
    }
}
?>
