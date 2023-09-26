<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hackernews_parts'; // Replace with your actual table name if different

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'poll_id', // Add this field for the foreign key relationship
        'text',
        // Add other fields specific to the 'Part' model
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false; // You can set this to true if you have timestamp columns

    /**
     * Define the relationship to the 'Poll' model.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }
}
