<?php
/**
 * Created by IntelliJ IDEA.
 * User: MoWagdy
 * Date: 2019-06-23
 * Time: 9:55 PM
 */

namespace App\Helpers;


class MoPhone
{
    private $phoneUtil;
    private $isValid;
    private $errorMsg = '';
    private $normalizedPhone;

    public function __construct($phoneNumber)
    {
        $this->phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        $parsedPhone = $this->parsingPhone($phoneNumber);
        if ($parsedPhone != null) {
            $this->validatePhone($parsedPhone);
            if ($this->isValid) {
                $this->formattingPhone($parsedPhone);
            }
        }
    }

    private function parsingPhone($phoneNumber)
    {
        try {
            return $this->phoneUtil->parse($phoneNumber, "EG");
        } catch (\libphonenumber\NumberParseException $e) {
            $this->errorMsg = $e->getMessage();
            return null;
        }
    }

    private function validatePhone($parsedPhoneNumber)
    {
        $this->isValid = $this->phoneUtil->isValidNumber($parsedPhoneNumber);
        if ($this->isValid == false) {
            $this->errorMsg = 'Wrong phone number';
        }
    }

    private function formattingPhone($parsedPhoneNumber)
    {
        $this->normalizedPhone = $this->phoneUtil
            ->format($parsedPhoneNumber, \libphonenumber\PhoneNumberFormat::E164);
    }

    public function getNormalized()
    {
        return $this->normalizedPhone;
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function errorMsg()
    {
        return $this->errorMsg;
    }
}
