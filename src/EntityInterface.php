<?php

namespace mgirouard\CloudFlare\Entities;

/**
 * An API entity is fully hydratable and serializable in JSON.
 */
interface EntityInterface extends \JsonSerializable
{
    /**
     * {@inheritDoc}
     *
     * Serializes an entity down to JSON.
     *
     * @return array
     */
    public function jsonSerialize();

    /**
     * Responsible for hydrating an entity from a JSON string
     *
     * @param string $json
     * @return EntityInterface
     */
    public static function jsonHydrate($json);

    /**
     * Maps fields from a JSON document to entity fields
     *
     * Entity fields are represented in PascalCase so accessors and mutators
     * can be used with little effort.
     *
     * @return array
     */
    public static function jsonMap();
}
