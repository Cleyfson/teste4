<?php

namespace App\Domain\Entities;

class Favorite implements \JsonSerializable
{
    private int $id;
    private int $userId;
    private int $movieId;
    private string $movieTitle;
    private ?string $originalTitle;
    private ?string $overview;
    private ?string $posterPath;
    private ?string $releaseDate;
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

    public function getOriginalTitle(): ?string 
    { 
        return $this->originalTitle; 
    }
    
    public function setOriginalTitle(?string $originalTitle): self 
    { 
        $this->originalTitle = $originalTitle; 
        return $this; 
    }

    public function getOverview(): ?string 
    { 
        return $this->overview; 
    }
    
    public function setOverview(?string $overview): self 
    { 
        $this->overview = $overview; 
        return $this; 
    }

    public function getPosterPath(): ?string 
    { 
        return $this->posterPath; 
    }
    
    public function setPosterPath(?string $posterPath): self 
    { 
        $this->posterPath = $posterPath; 
        return $this; 
    }

    public function getReleaseDate(): ?string 
    { 
        return $this->releaseDate; 
    }
    
    public function setReleaseDate(?string $releaseDate): self 
    { 
        $this->releaseDate = $releaseDate; 
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'movie_id' => $this->movieId,
            'movie_title' => $this->movieTitle,
            'original_title' => $this->originalTitle,
            'overview' => $this->overview,
            'poster_path' => $this->posterPath,
            'release_date' => $this->releaseDate,
            'genre_ids' => $this->genreIds,
        ];
    }
}
