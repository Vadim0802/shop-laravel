<?php

namespace Domain\Catalog\Models;

use Domain\Catalog\Builders\BrandBuilder;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Support\Traits\Models\Cacheable;
use Support\Traits\Models\HasSlug;
use Support\Traits\Models\HasThumbnail;

/**
 * @method static Builder|BrandBuilder query()
 */
class Brand extends Model
{
    use HasFactory;
    use HasSlug;
    use HasThumbnail;
    use Cacheable;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_homepage',
        'sorting',
    ];

    public function newEloquentBuilder($query): BrandBuilder
    {
        return new BrandBuilder($query);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function cache(): array
    {
        return [
            'brand_homepage',
            'brands_filter',
        ];
    }

    protected static function slugableField(): string
    {
        return 'title';
    }
}
