<?php

namespace Esened\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

//This class returns Exception as text
class EmailAvailableException extends ValidationException {

    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email is already taken.',
        ],

    ];


}