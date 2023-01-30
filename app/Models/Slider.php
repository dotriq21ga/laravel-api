<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumbnail',
    ];

    protected $hidden = ['pivot'];

    protected $table = 'sliders';

    public function sections()
    {
        return $this->morphToMany(Section::class, 'sectionable');
    }
}
