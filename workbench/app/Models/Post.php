<?php

declare(strict_types=1);

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Workbench\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory(): PostFactory
    {
        return PostFactory::new();
    }
}
