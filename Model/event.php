<?php
class Event {
    private ?int $id;                 // Unique ID of the event
    private ?string $title;          // Title of the event
    private ?string $description;    // Description of the event
    private ?string $date_start;     // Start date of the event
    private ?string $place;       // Location of the event
    private ?float $price;           // Price for attending the event
    private ?int $capacity;          // Maximum capacity for the event

    // Constructor
    public function __construct(
        ?int $id,
        ?string $title,
        ?string $description,
        ?string $date_start,
        ?string $place,
        ?float $price,
        ?int $capacity
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->date_start = $date_start;
        $this->place = $place;
        $this->price = $price;
        $this->capacity = $capacity;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(?string $title): void {
        $this->title = $title;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function getDateStart(): ?string {
        return $this->date_start;
    }

    public function setDateStart(?string $date_start): void {
        $this->date_start = $date_start;
    }

    public function getPlace(): ?string {
        return $this->place;
    }

    public function setPlace(?string $place): void {
        $this->place = $place;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(?float $price): void {
        $this->price = $price;
    }

    public function getCapacity(): ?int {
        return $this->capacity;
    }

    public function setCapacity(?int $capacity): void {
        $this->capacity = $capacity;
    }
}
?>
