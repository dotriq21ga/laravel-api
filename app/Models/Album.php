<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artists',
        'banner',
        'sort_description',
    ];

    protected $hidden = ['pivot'];

    protected $table = 'albums';

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable');
    }

    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
