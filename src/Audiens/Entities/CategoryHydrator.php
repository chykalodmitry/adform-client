<?php

namespace Audiens\AdForm\Entities;

/**
 * Class CategoryHydrator
 */
class CategoryHydrator extends Category
{
    /**
     * Hydrate a category from a stdClass, intended to be used for
     * instancing a category from json_decode()
     *
     * @param stdClass $stdClass
     *
     * @return Category
     */
    public static function fromStdClass(\stdClass $stdClass)
    {
        $category = new Category();
        $category->id = $stdClass->id;
        $category->name = $stdClass->name;
        $category->dataProviderId = (int)$stdClass->dataProviderId;

        // might not be set in JSON
        if (isset($stdClass->parentId)) {
            $category->parentId = (int)$stdClass->parentId;
        }

        $category->updatedAt = new \DateTime($stdClass->updatedAt);
        $category->createdAt = new \DateTime($stdClass->createdAt);

        return $category;
    }
}
