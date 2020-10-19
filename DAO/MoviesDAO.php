<?php

namespace DAO;

use Models\Movie as Movie;
use Models\Genre as Genre;

class MoviesDAO implements IMoviesDAO
{

    private $key;
    private $moviesList;
    private $genresList;


    public function __construct()
    {
        $this->key = "1f3979c9e201dad1503dce45eda6e92c";
    }

    public function getAll()
    {
        $this->retrieveDataNowPlaying();
        return $this->moviesList;
    }
    public function getKey()
    {
        return $this->key;
    }

    public function retrieveDataNowPlaying()
    {
        $this->retrieveGenres();
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
                        $genresToAdd = $this->getGenresByIds($movie['genre_ids']);
                        $newMovie->setGenres($genresToAdd);
                        array_push($this->moviesList, $newMovie);
                    }
                }
            }
        }
    }

    public function getGenreById($id)
    {
        $genreToSearch = false;


        if (is_array($this->genresList)) {

            foreach ($this->genresList as $key => $value) {

                if ($value->getId() == $id) {
                    $genreToSearch = $value;
                    break;
                }
            }
        }
        return $genreToSearch;
    }


    public function getGenresByIds($idsArray)
    {

        $genresList = array();

        foreach ($idsArray as $id) {
            $genre = $this->getGenreById($id);

            if ($genre != false) {
                array_push($genresList, $genre);
            }
        }

        return $genresList;
    }


    public function retrieveGenres()
    {
        $this->genresList = array();

        $json = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?api_key=$this->key&language=en-US");
        $arrayToDecode = json_decode($json, true);

        foreach ($arrayToDecode as $key => $value) {

            foreach ($value as $genres) {

                $newGenre = new Genre();
                $newGenre->setId($genres['id']);
                $newGenre->setName($genres['name']);
                array_push($this->genresList, $newGenre);
            }
        }
    }
}
