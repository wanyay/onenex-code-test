<?php


namespace App\Repository\Movie;


use App\Models\Movie;
use App\Repository\Repository;
use Illuminate\Database\Eloquent\Collection;

class MovieRepository extends Repository implements MovieRepositoryInterface
{
    protected function model(): string
    {
        return Movie::class;
    }

    protected function hasRelation(): string
    {
        return 'comment';
    }

    public function getMovieList(array $input): Collection
    {
        return $this->model
            ->skip($input['offset'])
            ->take($input['limit'])
            ->latest()
            ->get();
    }

    public function getMovieById(int $id): Movie
    {
        return $this->model->findOrFail($id);
    }

    public function storeMovie(array $input): Movie
    {
        return $this->model->create($input);
    }

    public function updateMovie(int $id, array $input): bool
    {
        return $this->getMovieById($id)->update($input);
    }

    public function destroyMovieById(int $id): bool
    {
        return $this->getMovieById($id)->delete();
    }
}
