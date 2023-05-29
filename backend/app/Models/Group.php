<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * The users that belong to the Group
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
