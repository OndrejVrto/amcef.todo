<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model {
    use HasFactory;

    /** @var boolean */
    public $timestamps = false;

    public function task(): BelongsToMany {
        return $this->belongsToMany(Task::class);
    }
}
