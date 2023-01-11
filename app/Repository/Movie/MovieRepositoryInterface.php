<?php


namespace App\Repository\Movie;


use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface MovieRepositoryInterface
{
    /**
     * @param array $input
     * @return Collection
     */
    public function getMovieList(array $input): Collection;

    /**
     * @param int $id
     * @return Movie
     */
    public function getMovieById(int $id): Movie;

    /**
     * @param array $input
     * @return Movie
     */
    public function storeMovie(array $input): Movie;

    /**
     * @param int $id
     * @param array $input
     * @return bool
     */
    public function updateMovie(int $id, array $input): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function destroyMovieById(int $id): bool;
}
