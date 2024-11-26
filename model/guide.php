<?php

class Guide {
    private ?int $id;                  
    private ?string $title;           // Titre du guide
    private ?string $description;     // Description du contenu du guide
    private ?string $language;        // Langue du guide

    private ?float $price;            // Prix du guide (si vendu)
    private ?string $category;        // Catégorie (ex. Culture, Nature)
    private ?string $region;      
    private ?string $city;  
    private ?string $country;    // Région ou lieu couvert par le guide
   
    // Constructor
    public function __construct(
        ?int $id,
        ?string $title,
        ?string $description,
        ?string $language,
       
        ?float $price,
        ?string $category,
        ?string $region,
        ?string $city,
        ?string $country,
        
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->language = $language;
       
        $this->price = $price;
        $this->category = $category;
        $this->region = $region;
        $this->city = $city;
        $this->country = $country;
      
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

    public function getLanguage(): ?string {
        return $this->language;
    }

    public function setLanguage(?string $language): void {
        $this->language = $language;
    }



    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(?float $price): void {
        $this->price = $price;
    }

    public function getCategory(): ?string {
        return $this->category;
    }

    public function setCategory(?string $category): void {
        $this->category = $category;
    }

    public function getRegion(): ?string {
        return $this->region;
    }

    public function setRegion(?string $region): void {
        $this->region = $region;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(?string $city): void {
        $this->city = $city;
    }
    public function getCountry(): ?string {
        return $this->country;
    }

    public function setCountry(?string $country): void {
        $this->country = $country;
    }

   
}

?>
