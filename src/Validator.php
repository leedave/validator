<?php

namespace Leedch\Validator;

/**
 * I hate validating, so I make sure I only write validation once by using this
 * Class
 *
 * @author leed
 */
abstract class Validator
{
    /**
     * Just Check if Date is YYYY-MM-DD HH:MM:SS
     * @param string $string
     * @return bool
     */
    public static function validateDate(string $string) : bool
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) ([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $string)) {
            return true;
        } else {
            return false;
        }
    }
}