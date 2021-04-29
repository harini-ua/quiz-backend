<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CategoryQuizQuestions extends Enum
{
    const CALL = 1;
    const SEE = 2;
    const SOUND = 3;
    const MADE = 4;
    const FOOD_DRINKS = 5;
    const ENTERTAINMENT = 6;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::CALL:
                return 'What would you call?';
            case self::SEE:
                return 'What can you see?';
            case self::SOUND:
                return 'What is this sound?';
            case self::MADE:
                return 'What is it made of?';
            case self::FOOD_DRINKS:
                return 'What would you pair it with?';
            case self::ENTERTAINMENT:
                return 'What would you do with?';
            default:
                return self::getKey($value);
        }
    }
}
