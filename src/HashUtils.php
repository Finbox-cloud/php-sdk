<?php

namespace Finbox\Sdk\Hash\HashUtils;

class HashUtils
{
    protected static function _flatten(array $array, string $path = ''): array
    {
        $return = array();

        array_walk($array, function ($item, $key) use (&$return, $path) {
            $_path = $path != '' ? $path . '.' . $key : $key;

            if (!is_array($item)) {
                $return[$_path] = $item;
            } else {
                $return = array_merge($return, self::_flatten($item, $_path));
            }
        });
        return $return;
    }

    protected static function _filterEmptyValues(array $data): array
    {
        return array_filter($data, function ($value) {
            return $value !== null && $value !== '';
        });
    }

    protected static function _concatDataKeyItems(array $data): array
    {
        $return = [];
        array_walk($data, function ($item, $key) use (&$return) {
            $return[] = $key . ':' . $item;
        });
        return $return;
    }

    protected static function _trimValues(array $data): array
    {
        return array_map(function ($v) {
            return trim($v);
        }, $data);
    }
}
