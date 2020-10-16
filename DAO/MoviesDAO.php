<?php

namespace DAO;

use Models\Movie as Movie;

class MoviesDAO implements IMoviesDAO
{

    private $key;
    private $moviesList;


    public function __construct()
    {
        $this->key = "1f3979c9e201dad1503dce45eda6e92c";
    }

    public function getAll(){
        $this->retrieveDataNowPlaying();
        return $this->moviesList;
    }
    public function getKey(){
        return $this->key;
    }

    public function retrieveDataNowPlaying()
    {

        $this->moviesList = array();
        $json = file_get_contents("https://api.themoviedb.org/3/movie/now_playing?api_key=$this->key&language=en-US&page=1");
        $arrayToDecode = json_decode($json, true);

        foreach ($arrayToDecode as $key => $value) {

            if (is_array($value)) {

                foreach ($value as $movie) {

                    if (is_array($movie)) {
                        $newMovie = new Movie();
                        $newMovie->setId($movie['id']);
                        $newMovie->setTitle($movie['title']);
                        $newMovie->setImg($movie['poster_path']);
                        $newMovie->setLanguage($movie['original_language']);
                        $newMovie->setOverview($movie['overview']);
                        $newMovie->setReleaseDate($movie['release_date']);
                        array_push($this->moviesList, $newMovie);
                    }
                }
            }
        }
    }
}
