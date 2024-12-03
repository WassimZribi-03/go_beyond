<?php
if (!class_exists('Booking')) {
    class Booking {
        private ?int $id;
        private ?int $tour_id;
        private ?string $customer_name;
        private ?string $customer_email;
        private ?string $customer_phone;
        private ?DateTime $booking_date;

        public function __construct(
            ?int $id = null,
            ?int $tour_id = null,
            ?string $customer_name = null,
            ?string $customer_email = null,
            ?string $customer_phone = null,
            ?DateTime $booking_date = null
        ) {
            $this->id = $id;
            $this->tour_id = $tour_id;
            $this->customer_name = $customer_name;
            $this->customer_email = $customer_email;
            $this->customer_phone = $customer_phone;
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

        public function getCustomerPhone(): ?string {
            return $this->customer_phone;
        }

        public function setCustomerPhone(?string $customer_phone): void {
            $this->customer_phone = $customer_phone;
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
