<?php


namespace App\maguttiCms\Tools;


/**
 * Class ErrorCodes
 * @package App\maguttiCms\Tools
 */
abstract class ErrorCodes
{
    const  GenericError = 100;
    //  Authentication and Authorization
    const AuthUnauthorized = 10;
    const UserUnauthorized = 11;
    //  Validation error
    const InvalidParameters = 20;
    const EmailAlreadyUsed = 21;
    const EmailInvalidFormat = 22;
    const WrongOldPassword = 23;
    const PasswordInvalidFormat = 24;
    const DataNotFound = 25;

}