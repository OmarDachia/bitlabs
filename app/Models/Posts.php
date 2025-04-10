<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Posts extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'color',
        'slug',
        'thumbnail',
        'tags',
        'is_published',
        'published_at',
    ];  

    protected $casts = [
        'tags' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
