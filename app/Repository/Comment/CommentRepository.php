<?php


namespace App\Repository\Comment;


use App\Models\Comment;
use App\Repository\Repository;

class CommentRepository extends Repository implements CommentRepositoryInterface
{
    protected function model(): string
    {
        return Comment::class;
    }

    public function storeComment(array $input): Comment
    {
        return $this->model->create($input);
    }

    protected function hasRelation(): string
    {
        return 'movies';
    }
}
