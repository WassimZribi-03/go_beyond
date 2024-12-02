<?php
if (!class_exists('Booking')) {
    class Booking {
        private ?int $id;
        private ?int $tour_id;
        private ?string $customer_name;
        private ?string $customer_email;
        private ?DateTime $booking_date;

        public function __construct(?int $id, ?int $tour_id, ?string $customer_name, ?string $customer_email, ?DateTime $booking_date) {
            $this->id = $id;
            $this->tour_id = $tour_id;
            $this->customer_name = $customer_name;
            $this->customer_email = $customer_email;
            $this->booking_date = $booking_date;
        }

        // Getters and Setters
        public function getId(): ?int {
            return $this->id;
        }

        public function setId(?int $id): void {
            $this->id = $id;
        }

        public function getTourId(): ?int {
            return $this->tour_id;
        }

        public function setTourId(?int $tour_id): void {
            $this->tour_id = $tour_id;
        }

        public function getCustomerName(): ?string {
            return $this->customer_name;
        }

        public function setCustomerName(?string $customer_name): void {
            $this->customer_name = $customer_name;
        }

        public function getCustomerEmail(): ?string {
            return $this->customer_email;
        }

        public function setCustomerEmail(?string $customer_email): void {
            $this->customer_email = $customer_email;
        }

        public function getBookingDate(): ?DateTime {
            return $this->booking_date;
        }

        public function setBookingDate(?DateTime $booking_date): void {
            $this->booking_date = $booking_date;
        }
    }
}
?>
