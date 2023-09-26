<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hackernews_polls'; // Replace with your actual table name if different

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'by',
        'descendants',
        'kids',
        'parts',
        'score',
        'text',
        'time',
        'title',
        'type',
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
     * Define the one-to-many relationship with the 'Part' model.
     */
    public function parts()
    {
        return $this->hasMany(Part::class, 'poll_id');
    }
}
