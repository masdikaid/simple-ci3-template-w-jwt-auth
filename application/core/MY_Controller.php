<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require('./vendor/autoload.php');


use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class MY_Controller extends CI_Controller
{
    protected $data = array();


    public function __construct()
    {
        parent::__construct();
        if (version_compare(CI_VERSION, '2.1.0', '<')) {
            $this->load->library('security');
        }

        $this->authCookieCheck();

        $this->load->library('parser');
        $this->load->library('user_agent');
        $this->load->helper('cookie');
        $this->load->helper('url');
        $this->load->helper('api_helper');

        $this->data['base_url'] = base_url();
    }


    protected function view(string $template): void
    {
        $this->parser->parse('default/header', $this->data);
        $this->parser->parse($template, $this->data);
        $this->parser->parse('default/footer', $this->data);
    }


    protected function viewWithObject(string $template, object $obj): void
    {
        $this->parser->parse('default/header', $this->data);
        $this->load->view($template, array_merge($this->data, array('data'=>$obj)));
        $this->parser->parse('default/footer', $this->data);
    }


    protected function forAjax(): void
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    }


    protected function verifyCredential(?string $hash): ?array
    {
        if ($hash!=null) {
            $extract = explode('!@#$%',base64_decode($hash));
            $email = $extract[0];
            $pass = $extract[1];
            if ($email === "admin@mail.com" && $pass === "MyPertamina135") {
                return array(
                    "id" => 1,
                    "name" => "Dika",
                    "email" => "admin@mail.com",
                    "occupation" => "Developer",
                    "company" => "DNA"
                );
            }
        }
        return null;
    }


    protected function checkAuth(): bool
    {
        $cookie = $this->getAuthCookie();
        if($cookie) {

            try {
                $res = $this->jwtDecode($cookie);
            }catch (Exception $ex){
                return false;
            }

            if ($res->is_logged_in) {
                if ($res->exp > time()) {
                    return true;
                }
                $this->setInitAuthCookie();
            }
            return false;
        }

        return false;
    }


    protected function getUser(): ?array
    {
        if ($this->checkAuth()) {
            $cookie = $this->getAuthCookie();
            try {
                $res = $this->jwtDecode($cookie);
                return (array) $res;
            }catch (Exception $ex){
                return null;
            }
        }

        return null;
    }


    protected function setUser(string $id,
                               string $name,
                               string $email,
                               string $occupation,
                               string $agency): array
    {

        $payload = [
            'iss' => base_url(),
            'aud' => base_url(),
            'iat' => time(),
            'nbf' => time(),
            'exp' => strtotime('+9 hours'),
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'occupation' => $occupation,
            'company' => $agency,
            'is_logged_in' => true
        ];

        $jwt = $this->jwtEncode($payload);
        $this->setAuthCookie($jwt);


        return $payload;
    }


    protected function logoutUser(): ?array
    {
        $this->setInitAuthCookie();

        return $this->getUser();
    }


    protected function setInitAuthCookie(): void
    {
        $payload = [
            'is_logged_in' => false
        ];

        $token = $this->jwtEncode($payload);
        $this->setAuthCookie($token);
    }


    protected function authCookieCheck(): void
    {
        $cookie = $this->getAuthCookie();
        if (!$cookie) {
            $this->setInitAuthCookie();
        }
    }


    protected function jwtEncode(array $payload): string
    {
        $key = config_item('WEB_KEY');
        JWT::$leeway = 10800;
        return JWT::encode($payload, $key, 'HS256');
    }


    protected function jwtDecode(string $jwt): stdClass
    {
        $key = config_item('WEB_KEY');

        return JWT::decode($jwt, new Key($key, 'HS256'));
    }


    protected function setAuthCookie($jwt): void
    {
        setcookie('c',$jwt,time()+60*60*9,"/","",false,true);
    }


    protected function getAuthCookie()
    {
        $cookie = $this->input->cookie('c');

        if (!empty($cookie)) {
            return $cookie;
        }

        return false;
    }
}


class MY_Auth_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->checkAuth()) {
            if ($this->input->is_ajax_request()) {
                ajax_response($this->output, 403, "invalid credential");
            }
            redirect('auth/login');
        }
        $this->data['user'] = $this->getUser();
    }


    protected function roleInclude(): void
    {
        $role = func_get_args();
        if (!in_array($this->data['user']['occupation'], $role, false)){
            if ($this->input->is_ajax_request()) {
                ajax_response($this->output, 403, "access forbidden");
            }
            show_404();
        }
    }


    protected function roleExclude(): void
    {
        $role = func_get_args();
        if (in_array($this->data['user']['occupation'], $role, false)){
            if ($this->input->is_ajax_request()) {
                ajax_response($this->output, 403, "access forbidden");
            }
            show_404();
        }
    }

}


class My404 extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        show_404();
    }
}