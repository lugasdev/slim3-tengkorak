<?php
use \Respect\Validation\Validator as v;

class Validate
{
    // static function validate_note($id)
    // {

    // }

    static function nip($input, $name = "input")
    {
        if (v::numeric()->length(15,20)->validate($input) == false) {
            throw new \ValidationException("{$name} is Not valid");
        }
    }

    static function phone($input, $name = "input")
    {
        if (v::numeric()->length(10,15)->validate($input) == false) {
            throw new \ValidationException("{$name} is Not valid");
        }
    }

    static function email($input, $name = "input")
    {
        if (v::email()->validate($input) == false) {
            throw new \ValidationException("{$name} is Not valid");
        }
    }

    static function required($input, $name = "input")
    {
        return self::notEmpty($input, $name);
    }

    static function notEmpty($input, $name = "input")
    {
        if (v::stringType()->notEmpty()->validate($input) == false OR v::notEmpty()->validate($input) == false) {
            throw new \ValidateException("{$name} tidak boleh kosong");
        }

        return true;
    }

    static function integer($input, $name = "input")
    {
        if (!empty($input) AND !v::stringType()->numeric()->validate($input)) {
            throw new \ValidateException("{$name} harus berupa angka");
        }

        return true;

    }
}