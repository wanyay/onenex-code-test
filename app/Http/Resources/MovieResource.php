<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'cover_image' => $this->getCoverImageUrl(),
            'genres' => $this->genres,
            'author' => $this->author,
            'tags' => $this->tags,
            'imdb_rate' => $this->imdb_rate,
            'comments' => CommentListResource::collection($this->comments),
            'related_movies' => MovieListResource::collection($this->related_movies),
            'pdf_download' => $this->pdf_download_link,
            'created_at' => $this->created_at->format('d-m-Y H:i:s'),
            'updated_at' => $this->updated_at->format('d-m-Y H:i:s')
        ];
    }
}
