<?php
class Categorie {
    private ?int $id_categ;           // Unique category ID of the event
    private ?string $categorie;       // Category of the event
    private ?int $disponibilite;      // Availability of the event (e.g., number of available spots)
    private ?string $organisateur;    // Organizer of the event

    // Constructor
    public function __construct(
        ?int $id_categ,
        ?string $categorie,
        ?int $disponibilite,
        ?string $organisateur
    ) {
        $this->id_categ = $id_categ;
        $this->categorie = $categorie;
        $this->disponibilite = $disponibilite;
        $this->organisateur = $organisateur;
    }

    // Getters and Setters
    public function getIdCateg(): ?int {
        return $this->id_categ;
    }

    public function setIdCateg(?int $id_categ): void {
        $this->id_categ = $id_categ;
    }

    public function getCategorie(): ?string {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): void {
        $this->categorie = $categorie;
    }

    public function getDisponibilite(): ?int {
        return $this->disponibilite;
    }

    public function setDisponibilite(?int $disponibilite): void {
        $this->disponibilite = $disponibilite;
    }

    public function getOrganisateur(): ?string {
        return $this->organisateur;
    }

    public function setOrganisateur(?string $organisateur): void {
        $this->organisateur = $organisateur;
    }
}
?>
