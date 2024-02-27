<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Config extends Model
{
    use HasFactory;

    protected $table = "configs";
    protected $guarded = ["id"];

    function Image() : HasMany {
        return $this->hasMany(Image::class, "config_id");
    }
}
