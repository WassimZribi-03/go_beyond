<?php

class Disponibility {
    private ?int $id;                  // Unique identifier for availability
    private ?int $id_guide;            // Guide ID
    private ?DateTime $available_date; // Availability date (DateTime object)
    private ?DateTime $start_time;     // Start time (DateTime object)
    private ?DateTime $end_time;       // End time (DateTime object)
    private ?bool $status;             // Availability status (true for Free, false for Busy)

    // Constructor
    public function __construct(
        ?int $id = null,
        ?DateTime $available_date = null,
        ?DateTime $start_time = null,
        ?DateTime $end_time = null,
        ?int $id_guide = null,
        ?bool $status = null
    ) {
        $this->id = $id;
        $this->available_date = $available_date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->id_guide = $id_guide;
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

    public function getAvailableDate(): ?DateTime {
        return $this->available_date;
    }

    public function setAvailableDate(?DateTime $available_date): void {
        $this->available_date = $available_date;
    }

    public function getStartTime(): ?DateTime {
        return $this->start_time;
    }

    public function setStartTime(?DateTime $start_time): void {
        $this->start_time = $start_time;
    }

    public function getEndTime(): ?DateTime {
        return $this->end_time;
    }

    public function setEndTime(?DateTime $end_time): void {
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
