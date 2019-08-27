<?php

class MyApp
{
    protected $session_;

    public function __construct() {
        $this->session_ = new \SlimSession\Helper;
    }

    public function SlimApp($settings)
    {
        return new \Slim\App( $settings );
    }

    public function getLogin()
    {
        $loginData = $this->session_->login_data;
        if (empty($loginData)) {
            return array();
        }

        return $loginData;
    }

    public function setAlert($msg = "", $type = "error")
    {
        $this->session_['alert_' . $type] = $msg;

        return true;
    }

    public function getAlert($type = "error")
    {
        $alerts = $this->session_['alert_' . $type];

        $this->session_['alert_' . $type] = "";

        return $alerts;
    }

}
