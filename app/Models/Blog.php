<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $table = "blogs";
    protected $guarded = ["id"];

    function user() : BelongsTo {
        return $this->belongsTo(User::class, "user_id");
    }
}
