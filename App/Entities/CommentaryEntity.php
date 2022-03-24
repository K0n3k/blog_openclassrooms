<?php

namespace App\Entities;
use DateTime;

class commentaryEntity {

    private int $id;
    private int $idBlogpost;
    private ?int $idUser;
    private ?string $firstname;
    private ?string $lastname;
    private string $commentary;
    private string $date;
    private bool $isValidated;
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of idBlogpost
     */ 
    public function getIdBlogpost()
    {
        return $this->idBlogpost;
    }

    /**
     * Set the value of idBlogpost
     *
     * @return  self
     */ 
    public function setIdBlogpost($idBlogpost)
    {
        $this->idBlogpost = $idBlogpost;

        return $this;
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of commentary
     */ 
    public function getCommentary()
    {
        return $this->commentary;
    }

    /**
     * Set the value of commentary
     *
     * @return  self
     */ 
    public function setCommentary($commentary)
    {
        $this->commentary = $commentary;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of isValidated
     */ 
    public function getIsValidated()
    {
        return $this->isValidated;
    }

    /**
     * Set the value of isValidated
     *
     * @return  self
     */ 
    public function setIsValidated($isValidated)
    {
        $this->isValidated = $isValidated;

        return $this;
    }
}