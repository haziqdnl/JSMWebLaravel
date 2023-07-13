<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class ValidationHelper
{
    public static $validatorMsg = [
        'required' => ':Attribute is required!',
        'min' => ':Attribute is less than the minimum length!',
        'max' => ':Attribute is more than the maximum length!',
        'email' => 'Invalid email address!',
        'alpha' => 'Invalid :attribute!',
        'integer' => 'Invalid :attribute!',
        'numeric' => 'Invalid :attribute!',
        'between' => 'Invalid :attribute!',
        'date' => 'Invalid date!'
    ];

    public static function customValidation($attr, $isValid) {
        if (!empty($attr)) {
            if ($isValid)
                return true;
            else {
                error_log('Invalid value: '.$attr);
                return false;
            }
        }
        else return false;
    }

    public static function isEmail($attr) {
        return Validator::make(
            ['email' => $attr],
            ['email' => 'email|max:255'],
            self::$validatorMsg
        );
    }

    public static function isMobileNo($attr) {
        return Validator::make(
            ['MobileNo' => $attr],
            ['MobileNo' => 'numeric|min:10|max:12'],
            self::$validatorMsg
        );
    }

    public static function isFullname($attr) {
        return Validator::make(
            ['MobileNo' => $attr],
            ['MobileNo' => 'min:3|max:255'],
            self::$validatorMsg
        );
    }
}