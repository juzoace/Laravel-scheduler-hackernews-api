<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'authors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'karma',
        'about',
        'username',
        // 'story_id', // This column represents the associated story
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define the relationship with stories.
     */
    public function stories()
    {
        return $this->hasMany(Story::class, 'author_id', 'id');
    }

    /**
     * Define the relationship with comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'author_id', 'id');
    }
}
