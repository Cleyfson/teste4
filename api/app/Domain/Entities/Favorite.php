<?php

namespace App\Domain\Entities;

class Favorite
{
    private int $id;
    private int $userId;
    private int $movieId;
    private string $movieTitle;
    private array $genreIds;

    public function getId(): int 
    { 
        return $this->id; 
    }
    
    public function setId(int $id): self 
    { 
        $this->id = $id; 
        return $this; 
    }

    public function getUserId(): int 
    { 
        return $this->userId; 
    }
    
    public function setUserId(int $userId): self 
    { 
        $this->userId = $userId; 
        return $this; 
    }

    public function getMovieId(): int 
    { 
        return $this->movieId; 
    }
    
    public function setMovieId(int $movieId): self 
    { 
        $this->movieId = $movieId; 
        return $this; 
    }

    public function getMovieTitle(): string 
    { 
        return $this->movieTitle; 
    }
    
    public function setMovieTitle(string $movieTitle): self 
    { 
        $this->movieTitle = $movieTitle; 
        return $this; 
    }

    public function getGenreIds(): array 
    { 
        return $this->genreIds; 
    }
    
    public function setGenreIds(array $genreIds): self 
    { 
        $this->genreIds = $genreIds; 
        return $this; 
    }
}