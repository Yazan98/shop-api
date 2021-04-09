<?php

namespace App\Models\Services\Validations;

use App\Exceptions\BadInformationException;

class ShopStringValidation {

    static function isEnglishRequired($language) {
        return self::isStringsEquals($language, "en");
    }

    /**
     * @param $targetString
     * @param $errorMessage
     * @throws BadInformationException
     */
    static function validateEmptyString($targetString, $errorMessage) {
        if ($targetString == null) {
            throw new BadInformationException($errorMessage);
        }

        if (empty($targetString)) {
            throw new BadInformationException($errorMessage);
        }
    }

    static function isStringsEquals($first, $second) {
        return strcmp($first, $second) == 0;
    }

    /**
     * @param $targetString
     * @param $errorMessage
     * @param $size
     * @throws BadInformationException
     */
    static function validateStringMinLength($targetString, $errorMessage, $size) {
        self::validateEmptyString($targetString, $errorMessage);
        if (strlen($targetString) < $size) {
            throw new BadInformationException($errorMessage);
        }
    }

    /**
     * @param $targetString
     * @param $errorMessage
     * @param $size
     * @throws BadInformationException
     */
    static function validateStringMaxLength($targetString, $errorMessage, $size) {
        self::validateEmptyString($targetString, $errorMessage);
        if (strlen($targetString) > $size) {
            throw new BadInformationException($errorMessage);
        }
    }

    /**
     * @param $targetString
     * @param $errorMessage
     * @throws BadInformationException
     */
    static function validateEmail($targetString, $errorMessage) {
        self::validateEmptyString($targetString, $errorMessage);
        $pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
        if (preg_match($pattern, $targetString) !== 1) {
            throw new BadInformationException($errorMessage);
        }
    }

}
