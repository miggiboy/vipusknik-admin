<?php

namespace App;

use Illuminate\Support\Str;

class KeyboardLayoutConverter
{
    const MAPPING = [
        'q' => 'й',
        'w' => 'ц',
        'e' => 'у',
        'r' => 'к',
        't' => 'е',
        'y' => 'н',
        'u' => 'г',
        'i' => 'ш',
        'o' => 'щ',
        'p' => 'з',
        '[' => 'х',
        ']' => 'ъ',
        '`' => 'ё',
        'a' => 'ф',
        's' => 'ы',
        'd' => 'в',
        'f' => 'а',
        'g' => 'п',
        'h' => 'р',
        'j' => 'о',
        'k' => 'л',
        'l' => 'д',
        ';' => 'ж',
        "'" => 'э',
        'z' => 'я',
        'x' => 'ч',
        'c' => 'с',
        'v' => 'м',
        'b' => 'и',
        'n' => 'т',
        'm' => 'ь',
    ];

    public static function convert($string)
    {
        $keyMapping = collect(static::MAPPING)
            ->merge(
                collect(static::MAPPING)->flip()
            );

        return collect(
                preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY)
            )
            ->map(function ($char) {
                return Str::lower($char);
            })
            ->map(function ($char) use ($keyMapping) {
                return $keyMapping->first(function ($_, $key) use ($char) {
                    return $key === $char;
                }, $char);
            })
            ->implode('');
    }
}
