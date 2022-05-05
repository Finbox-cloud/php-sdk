<?php

namespace Finbox\Sdk\Hash;

use Finbox\Sdk\Hash\HashUtils\HashUtils;

class Hash extends HashUtils
{
    public static function hash(array $data, string $secret): string
    {
        $flatten = self::_flatten($data);
        $flatten = self::_filterEmptyValues($flatten);
        $flatten = self::_trimValues($flatten);
        $concatenated = self::_concatDataKeyItems($flatten);
        $concatenated[] = $secret;
        $string = join('|', $concatenated);

        return md5($string);
    }
}
