<?php
    namespace DAO;

    use DAO\IMovieDAO as IMovieDAO;
    use Models\Movie as Movie;
    use DAO\Connection as Connection;
    use \Exception as Exception;

    class MoviesDAOMySQL implements IMoviesDAO
    {
        private $key;
        private $connection;
        private $tableName = "movie";

        public function __construct()
        {
            $this->key = "1f3979c9e201dad1503dce45eda6e92c";
        }

        public function add(Movie $movie)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (id, title, img, realeseDate, language, overview) VALUES (:id, :title, :img ,:realeseDate, :language, :overview);";
                $parameters["id"] = $movie->getId();
                $parameters["title"] = $movie->getTitle();
                $parameters["img"] = $movie->getImg();
                $parameters["realeseDate"] = $movie->getReleaseDate();
                $parameters["language"] = $movie->getLanguage();
                $parameters["overview"] = $movie->getOverview();
            


                $this->connection = Connection::GetInstance();

                $this->connection->Execute('nonQuery', $query, $parameters);
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }
        
        
        public function delete($id)
        {   
            try
            {
            $query = "DELETE FROM ". $this->tableName . " WHERE ". $this->tableName . ".id ='$id'";
                $this->connection = Connection::GetInstance();
                $this->connection->Execute('nonQuery', $query);
            }
            catch(Exception $ex)
            {
               throw $ex;
            }
        }          

        public function getAll()
        {
            try
            {
                $movieList = array();

                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute('query', $query);
                
                foreach ($resultSet as $row)
                {                
                    $movie = new Movie();
                    $movie->setId($row["id"]);
                    $movie->setTitle($row["title"]);
                    $movie->setImg($row["img"]);
                    $movie->setReleaseDate($row["releaseDate"]);
                    $movie->setLanguage($row["language"]);
                    $movie->setOverview($row["overview"]);
                

                    array_push($movieList, $movie);
                }

                return $movieList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }       
        
        /*
        
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


        */
             
        
    }
?>