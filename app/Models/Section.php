<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';

    public function albums()
    {
        return $this->morphedByMany(Album::class, 'sectionable');
    }

    public function sliders()
    {
        return $this->morphedByMany(Slider::class, 'sectionable');
    }
}
