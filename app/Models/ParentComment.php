<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentComment extends Model
{
    protected $fillable = [
        'by',
        'id',
        'text',
        'time',
        'type',
        'story_id',
    ];

    public function childComments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
