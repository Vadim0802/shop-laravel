<?php

declare(strict_types=1);

namespace Domain\Catalog\Builders;

use Illuminate\Database\Eloquent\Builder;

final class BrandBuilder extends Builder
{
    public function homepage(): self
    {
        return $this->select(['id', 'title', 'thumbnail', 'slug'])
            ->where('on_homepage', true)
            ->orderBy('sorting')
            ->limit(6);
    }
}