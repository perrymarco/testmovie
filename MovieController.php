<?php 
class MovieController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function createMovie($title, $year, $story) {
        $query = "INSERT INTO movies (title, year, story) VALUES (:title, :year, :story)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':story', $story, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getMovieById($movieId) {
        $query = "SELECT * FROM movies WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateMovie($movieId,$title, $year, $story) {
        $query = "UPDATE movies SET title = :title, year = :year, story = :story WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->bindParam(':story', $story, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteMovie($movieId) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM movie_actor WHERE movie_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
            $stmt->execute();

            $query = "DELETE FROM movie_director WHERE movie_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
            $stmt->execute();

            $query = "DELETE FROM movie_genre WHERE movie_id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
            $stmt->execute();
    
            $query = "DELETE FROM movies WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $movieId, PDO::PARAM_INT);
            $stmt->execute();

            $this->db->commit();
    
        } catch (PDOException $e) {
            $this->db->rollBack(); 
            throw $e; 
        }
    }

    public function getAllMovies($orderby='') {
        $query = "SELECT * FROM movies ".$orderby;
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActorsForMovie($movieId) {
        $query = "SELECT actors.id, actors.lastname, actors.firstname
                  FROM actors
                  JOIN movie_actor ON actors.id = movie_actor.actor_id
                  WHERE movie_actor.movie_id = :movieId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':movieId', $movieId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getApiMovies(){
        $query="SELECT
        m.title AS title,
        g.name AS genre,
        GROUP_CONCAT(DISTINCT CONCAT(d.firstname, ' ', d.lastname)) AS directors,
        GROUP_CONCAT(DISTINCT CONCAT(a.firstname, ' ', a.lastname)) AS casts,
        m.year AS exityear
        FROM
            movies m
        LEFT JOIN
            movie_director md ON m.id = md.movie_id
        LEFT JOIN
            directors d ON md.director_id = d.id
        LEFT JOIN
            movie_actor ma ON m.id = ma.movie_id
        LEFT JOIN
            actors a ON ma.actor_id = a.id
        LEFT JOIN
            movie_genre mg ON m.id = mg.movie_id
        LEFT JOIN
            genres g ON mg.genre_id = g.id
        GROUP BY
            m.id
        ORDER BY
            m.title";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}