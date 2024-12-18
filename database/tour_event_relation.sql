-- Create tour_event_relation table to link tours with events
CREATE TABLE IF NOT EXISTS `tour_event_relation` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `tour_id` int(11) NOT NULL,
    `event_id` int(11) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_tour_event` (`tour_id`, `event_id`),
    FOREIGN KEY (`tour_id`) REFERENCES `tours`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`event_id`) REFERENCES `gestionevent`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 