<?php


namespace App\Models;


class AuthResponse
{

    public $user;
    public $token;
    public $tokenKey = "Bearer";

    /**
     * AuthResponse constructor.
     * @param $user
     * @param $token
     * @param string $tokenKey
     */
    public function __construct($user, $token, $tokenKey)
    {
        $this->user = $user;
        $this->token = $token;
        $this->tokenKey = $tokenKey;
    }


    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }


    /**
     * @return string
     */
    public function getTokenKey()
    {
        return $this->tokenKey;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

}


