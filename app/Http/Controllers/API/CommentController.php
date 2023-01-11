<?php


namespace App\Http\Controllers\API;


use App\Http\Requests\CreateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Movie;
use App\Repository\Comment\CommentRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CommentController extends ApiController
{

    protected CommentRepositoryInterface $commentRepository;

    /**
     * CommentController constructor.
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(Movie $movie, CreateCommentRequest $request): JsonResponse
    {
        $input = $request->validated();
        $input['movie_id'] = $movie->id;
        $comment = $this->commentRepository->storeComment($input);
        return $this->sendResponse(new CommentResource($comment), Response::HTTP_OK);
    }
}
