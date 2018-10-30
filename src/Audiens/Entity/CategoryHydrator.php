<?php declare(strict_types=1);

namespace Audiens\AdForm\Entity;

use DateTime;
use stdClass;

/**
 * Class CategoryHydrator
 */
class CategoryHydrator extends Category
{
    /**
     * Hydrate a category from a stdClass, intended to be used for
     * instancing a category from \json_decode()
     *
     * @param stdClass $stdClass
     *
     * @return Category
     */
    public static function fromStdClass(stdClass $stdClass): Category
    {
        $category = new Category();
        $category->id = (int)$stdClass->id;
        $category->name = $stdClass->name;
        $category->dataProviderId = (int)$stdClass->dataProviderId;

        // might not be set in JSON
        if (isset($stdClass->parentId)) {
            $category->parentId = (int)$stdClass->parentId;
        }

        $category->updatedAt = new DateTime($stdClass->updatedAt);
        $category->createdAt = new DateTime($stdClass->createdAt);

        return $category;
    }
}
