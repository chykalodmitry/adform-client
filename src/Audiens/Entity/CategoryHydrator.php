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

        $category->updatedAt = DateParser::parse($stdClass->updatedAt);
        $category->createdAt = DateParser::parse($stdClass->createdAt);

        return $category;
    }
}
