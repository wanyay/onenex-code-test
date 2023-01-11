<?php

namespace App\Repository\Comment;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * @param array $input
     * @return Comment
     */
    public function storeComment(array $input): Comment;
}
