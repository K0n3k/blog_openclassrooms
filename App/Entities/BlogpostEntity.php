<?php

namespace App\Entities;
use DateTime;

class BlogpostEntity {

    private int $id;
    private int $idAuthor;
    private string $title;
    private string $slug;
    private string $chapo;
    private string $content;
    private string $publishedDate;
    private string $lastUpdate;
    private bool $isPublished;
    

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
     * Get the value of idAuthor
     */ 
    public function getIdAuthor()
    {
        return $this->idAuthor;
    }

    /**
     * Set the value of idAuthor
     *
     * @return  self
     */ 
    public function setIdAuthor($idAuthor)
    {
        $this->idAuthor = $idAuthor;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of slug
     */ 
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of chapo
     */ 
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * Set the value of chapo
     *
     * @return  self
     */ 
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;

        return $this;
    }

    /**
     * Get the value of content
     */ 
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of publishedDate
     */ 
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * Set the value of publishedDate
     *
     * @return  self
     */ 
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get the value of lastUpdate
     */ 
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set the value of lastUpdate
     *
     * @return  self
     */ 
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get the value of isPublished
     */ 
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * Set the value of isPublished
     *
     * @return  self
     */ 
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}