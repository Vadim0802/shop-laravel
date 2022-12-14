<?php

namespace Domain\Catalog\Models;

use Domain\Catalog\Builders\CategoryBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\Cacheable;
use Support\Traits\Models\HasSlug;

class Category extends Model
{
    use HasFactory;
    use HasSlug;
    use Cacheable;

    protected $fillable = [
        'title',
        'slug',
        'on_homepage',
        'sorting',
    ];

    public function newEloquentBuilder($query): CategoryBuilder
    {
        return new CategoryBuilder($query);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    protected static function cache(): array
    {
        return [
            'category_homepage',
            'categories',
        ];
    }

    protected static function slugableField(): string
    {
        return 'title';
    }
}
