<?php

declare(strict_types=1);

namespace Rebing\GraphQL\Support;

use GraphQL\Type\Definition\Type as GraphqlType;
use GraphQL\Type\Definition\UnionType as BaseUnionType;

abstract class UnionType extends Type
{
    /**
     * @return GraphqlType[]
     */
    abstract public function types(): array;

    /**
     * Get the attributes from the container.
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = parent::getAttributes();
        $types = $this->types();

        if (count($types)) {
            $attributes['types'] = $types;
        }

        if (method_exists($this, 'resolveType')) {
            $attributes['resolveType'] = [$this, 'resolveType'];
        }

        return $attributes;
    }

    public function toType(): GraphqlType
    {
        return new BaseUnionType($this->toArray());
    }
}
