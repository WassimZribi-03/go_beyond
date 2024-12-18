<?php
class Reservation
{
    private $id;
    private $userId;
    private $guideId;
    private $disponibilityId;
   

    
    public function __construct($id, $userId, $guideId, $disponibilityId)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->guideId = $guideId;
        $this->disponibilityId = $disponibilityId;
  
    }


    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getGuideId()
    {
        return $this->guideId;
    }

    public function getDisponibilityId()
    {
        return $this->disponibilityId;
    }

   
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setGuideId($guideId)
    {
        $this->guideId = $guideId;
    }

    public function setDisponibilityId($disponibilityId)
    {
        $this->disponibilityId = $disponibilityId;
    }
}
  
?>
