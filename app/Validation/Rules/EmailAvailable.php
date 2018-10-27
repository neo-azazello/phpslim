<?php

namespace Esened\Validation\Rules;

use Esened\Models\User;
use Respect\Validation\Rules\AbstractRule;

//This rule will check if this email already exists in the User table in database
//Returns boolean
class EmailAvailable extends AbstractRule {

    public function validate($input)
    {
        return User::where('email', $input)->count() == 0;
    }

}