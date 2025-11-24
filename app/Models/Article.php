<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id');
    }

    public function comments(): HasMany {
        return $this->hasMany(related: Comment::class, foreignKey: 'article_id');
    }
}
