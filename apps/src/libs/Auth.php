<?php

class Auth
{
    private $sess;

    public function __construct()
    {
        $this->sess = new \SlimSession\Helper;
    }

    public function getLogin()
    {
        $loginData = $this->sess->login_data;
        if (empty($loginData)) {
            return array();
        }

        return $loginData;
    }

    public function setLogin()
    {
        $src_user = new \Models\Users();

        $src_user->username = $this->username;
        $src_user->password = $this->password;
        $result = $src_user->loginCheck();

        if (!empty($result)) {
            $result = $result->toArray();

            $this->sess->login_data = $result;

            return true;
        }

        return false;
    }
}
