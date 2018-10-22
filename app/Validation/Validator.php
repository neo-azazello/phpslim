<?php

namespace Esened\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator {

    protected $errors;

    public function validate($request, array $rules) {
        
        //Here we are looping for our validation rules which comes from AuthController.    
        foreach ($rules as $field => $rule) {
            try {
                
                //Checking if it fails
                $rule->setName(ucfirst($field))->assert($request->getParam($field));

            } catch (NestedValidationException $e) {
                
                //If failed we appending the error message to our $error property
                $this->errors[$field] = $e->getMessages();
                
            }
        }
        
        return $this;
    }


    public function failed(){

        return !empty($this->errors);
    
    }

}