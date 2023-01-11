<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'summary', 'cover_image', 'genres', 'author', 'tags', 'imdb_rate'
    ];

    protected $appends = ['related_movies', 'pdf-download-link'];

    /**
     * @return string|null
     */
    public function getCoverImageUrl(): ?string
    {
        if (!is_null($this->cover_image)) {
            return Storage::disk('public')->url($this->cover_image);
        }
        return null;
    }

    /**
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getRelatedMoviesAttribute()
    {
        return $this->where(function ($query) {
            $query->orWhere('author', $this->author)
                ->orWhere('tags', $this->tags)
                ->orWhere('genres', $this->generes);
        })->where('id','!=', $this->id)
            ->take(7)
            ->get();
    }

    /**
     * @return string
     */
    public function getPdfDownloadLinkAttribute(): string
    {
        return url("/movie/{$this->id}/pdf-download");
    }
}
