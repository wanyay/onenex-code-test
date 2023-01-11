<?php


namespace App\Http\Controllers\API;


use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieListResource;
use App\Http\Resources\MovieResource;
use App\Repository\Movie\MovieRepository;
use App\Repository\Movie\MovieRepositoryInterface;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends ApiController
{

    /**
     * @var MovieRepository|MovieRepositoryInterface
     */
    protected MovieRepository|MovieRepositoryInterface $movieRepository;

    /**
     * @var MediaService
     */
    protected MediaService $mediaService;

    /**
     * MovieController constructor.
     * @param MovieRepositoryInterface $movieRepository
     * @param MediaService $mediaService
     */
    public function __construct(MovieRepositoryInterface $movieRepository, MediaService $mediaService)
    {
        $this->movieRepository = $movieRepository;
        $this->mediaService = $mediaService;
    }

    public function store(CreateMovieRequest $request): JsonResponse
    {
        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->mediaService->saveMedia($request->file('cover_image'));
        }

        $movie = $this->movieRepository->storeMovie($data);

        return $this->sendResponse(new MovieResource($movie), Response::HTTP_CREATED);
    }

    public function update($id, Request $request): JsonResponse
    {
        $data = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $movie = $this->movieRepository->getMovieById($id);
            $this->mediaService->deleteMedia($movie->cover_image);
            $data['cover_image'] = $this->mediaService->saveMedia($request->file('cover_image'));
        }

        $result = $this->movieRepository->updateMovie($id, $data);

        return $this->sendResponse(['updated' => $result], Response::HTTP_OK);
    }

    public function index(Request $request): JsonResponse
    {
        $input = $request->only('limit', 'offset');

        $this->limit = $input['limit'] ?? 30;
        $this->offset = $input['offset'] ?? 0;

        $movies = $this->movieRepository->getMovieList(['limit' => $this->limit, 'offset' => $this->offset]);

        $this->total = $movies->count();

        return $this->sendResponse(
            MovieListResource::collection($movies)->toArray($request),
            Response::HTTP_OK
        );
    }

    public function show($id): JsonResponse
    {
        $movies = $this->movieRepository->getMovieById($id);

        return $this->sendResponse(new MovieResource($movies), Response::HTTP_OK);
    }

    public function destroy($id): JsonResponse
    {
        $movie = $this->movieRepository->getMovieById($id);
        $this->mediaService->deleteMedia($movie->cover_image);
        $result = $this->movieRepository->destroyMovieById($movie->id);
        return $this->sendResponse(['deleted' => $result], Response::HTTP_OK);
    }
}
