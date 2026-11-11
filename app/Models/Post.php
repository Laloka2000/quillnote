<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category_id',
        'user_id',
        'published_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function readTime(int $wordPerMinute = 200): int
    {
        $words = preg_split('/\s+/u', trim(strip_tags($this->content)), -1, PREG_SPLIT_NO_EMPTY);

        return max(1, (int) ceil(count($words) / $wordPerMinute));
    }
}
