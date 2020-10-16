<?php 
namespace Models;

class Movie{

    private $id;
    private $title;
    private $img;
    private $releaseDate;
    private $language;
    private $overview;

    public function __construct()
    {
        
    }
    

    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }


    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;

    }

    public function getOverview()
    {
        return $this->overview;
    }

    public function setOverview($overview)
    {
        $this->overview = $overview;

    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

    }
}


?>