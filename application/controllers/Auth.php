<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller
{

	public function login()
	{
        $this->loginRedirect();

        $this->data['title'] = "Login";
        $this->view('pages/auth/login-page');
	}


    public function dologin()
    {
        $this->forAjax();
        $hash = $this->input->post('hash');
        $cred = $this->verifyCredential($hash);

        if ($cred !== null) {
            $data = $this->setUser($cred['id'], $cred['name'], $cred['email'], $cred['occupation'], $cred['company']);
            ajax_response($this->output, 200, 'success login', $data);

        } else {
            ajax_response($this->output, 401, 'invalid email & password');
        }
    }


    public function dologout()
    {
        $this->logoutUser();
        redirect('auth/login');
    }


    private function loginRedirect(): void
    {
        if ($this->checkAuth()) {
            redirect('');
        }
    }
}
