<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

abstract class AbstractFilter implements \Stringable
{
    protected const ROOT_KEY = 'filters';

    public function __invoke(Builder $builder, $next)
    {
        return $next($this->apply($builder));
    }

    public function __toString(): string
    {
        return view($this->view(), ['filter' => $this])->render();
    }

    public function filterValueFromRequest(string $nested = null, mixed $default = null): mixed
    {
        $chain = Str::of(static::ROOT_KEY)
            ->append('.' . $this->filterKeyInRequest())
            ->when($nested, fn (Stringable $str) => $str->append(".$nested"));

        return Request::input($chain, $default);
    }

    public function nameAttribute(string $nested = null): string
    {
        return Str::of($this->filterKeyInRequest())
            ->wrap('[', ']')
            ->prepend(static::ROOT_KEY)
            ->when($nested, fn (Stringable $str) => $str->append("[$nested]"))
            ->value();
    }

    public function idAttribute(string $nested = null): string
    {
        return Str::slug($this->nameAttribute($nested));
    }

    abstract public function apply(Builder $query): Builder;

    abstract public function view(): string;

    abstract public function viewTitle(): string;

    abstract public function viewValues(): array;

    abstract public function filterKeyInRequest(): string;
}
