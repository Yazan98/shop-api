<?php


namespace App\Exceptions;

/**
 * Class BadInformationException
 * @package App\Exceptions
 *
 * This Exception Will Throw if Some Data from Services Failed During Validation
 */
class BadInformationException extends \Exception
{

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Throwable $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}
