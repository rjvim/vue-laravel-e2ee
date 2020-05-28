<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'content','title'
    ];

    /**
     * The roles that belong to the user.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot(['role'])->withTimestamps();
    }
}
