<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OwnerType;
use App\Enums\TaskStatus;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model {
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tasks';

    /** @var array<int,string> */
    protected $fillable = [
        'title',
        'description',
        'deadline_until',
        'status',
    ];

    /** @var array<string,string> */
    protected $casts = [
        'deadline_until' => 'datetime:Y-m-d',
        'status'         => TaskStatus::class,
        'owner_type'     => OwnerType::class,
    ];

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class)->withPivot('owner_type');
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class);
    }

    protected function isOwner(): Attribute {
        return Attribute::make(
            get: fn (): bool => OwnerType::OWNER === $this->owner_type,
        );
    }

    protected function isGuest(): Attribute {
        return Attribute::make(
            get: fn (): bool => OwnerType::GUEST === $this->owner_type,
        );
    }

    protected function cropDescription(): Attribute {
        return Attribute::make(
            get: fn (): string => Str::words($this->description, 5),
        );
    }

    protected function deadlineForHuman(): Attribute {
        return Attribute::make(
            get: fn (): string => $this->deadline_until->shortRelativeDiffForHumans(),
        );
    }
}
