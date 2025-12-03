<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'article_id',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(related: User::class, foreignKey:'user_id');
    }

    public function article(): BelongsTo {
        return $this->belongsTo(related: Article::class, foreignKey:'article_id');
    }
}
