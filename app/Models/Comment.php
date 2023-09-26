<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments'; // Replace with your actual table name if different

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'by',
        'text',
        'time',
        'type',
        'story_id', // This column represents the associated story
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id'; // Assuming 'id' is the primary key

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; // You can set this to true if you have timestamp columns

    /**
     * Define the relationship with the author.
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    /**
     * Define the relationship with the story.
     */
    public function story()
    {
        return $this->belongsTo(Story::class, 'story_id', 'id');
    }
}
