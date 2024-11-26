<?php

class Disponibility {
    private ?int $id;                   // Unique identifier for availability
    private ?int $id_guide;             // Guide ID
    private ?string $available_date;    // Availability date
    private ?string $start_time;        // Start time
    private ?string $end_time;          // End time
    private ?bool $status;              // Availability status (true for Free, false for Busy)

    // Constructor
    public function __construct(
        ?int $id = null,
        ?int $id_guide = null,
        ?string $available_date = null,
        ?string $start_time = null,
        ?string $end_time = null,
        ?bool $status = null
    ) {
        $this->id = $id;
        $this->id_guide = $id_guide;
        $this->available_date = $available_date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->status = $status;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getIdGuide(): ?int {
        return $this->id_guide;
    }

    public function setIdGuide(?int $id_guide): void {
        $this->id_guide = $id_guide;
    }

    public function getAvailableDate(): ?string {
        return $this->available_date;
    }

    public function setAvailableDate(?string $available_date): void {
        $this->available_date = $available_date;
    }

    public function getStartTime(): ?string {
        return $this->start_time;
    }

    public function setStartTime(?string $start_time): void {
        $this->start_time = $start_time;
    }

    public function getEndTime(): ?string {
        return $this->end_time;
    }

    public function setEndTime(?string $end_time): void {
        $this->end_time = $end_time;
    }

    public function getStatus(): ?bool {
        return $this->status;
    }

    public function setStatus(?bool $status): void {
        $this->status = $status;
    }
}

?>
