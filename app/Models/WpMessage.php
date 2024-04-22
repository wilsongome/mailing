<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WpMessage extends Model
{
    use HasFactory;

    public function wpMedia() : BelongsTo
    {
        return $this->belongsTo(WpMedia::class);
    }
}
