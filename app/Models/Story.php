<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $table = 'stories'; // This is the default in Laravel, so it can be omitted if not changed

    protected $fillable = [
        'id',
        'deleted',
        'type',
        'by',
        'time',
        'text',
        'dead',
        // 'parent',
        'poll',
        'url',
        'score',
        'title',
        'parts',
        'descendants',
        'author_id',  // Added this
        'category',   // New addition for category
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'story_id', 'id');
    }
}
