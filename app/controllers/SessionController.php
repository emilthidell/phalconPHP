<?php
namespace Cities\Controllers;

use Cities\Forms\LoginForm;
use Cities\Forms\SignUpForm;
use Cities\Forms\ForgotPasswordForm;
use Cities\Auth\Exception as AuthException;
use Cities\Models\Users;
use Cities\Models\Cities;
use Cities\Models\Buildings;
use Cities\Models\Characters;
use Cities\Models\ResetPasswords;

/**
 * Controller used handle non-authenticated session actions like login/logout, user signup, and forgotten passwords
 */
class SessionController extends ControllerBase
{

    public $currentUserId;

    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function initialize()
    {
        $loginState = 0;
        if(is_array($this->auth->getIdentity())){

            $currentUser = $this->auth->getIdentity();

            $this->currentUserId = $currentUser['id'];

            $loginState = 1;

            $cities = Cities::find("user_id = ".$currentUser['id']);

            if(count($cities) <= 1){
                $this->view->setVar('current_city', $cities[0]->id);
            }

            $this->view->setVar('num_cities', count($cities));

        }
        $this->view->setVar('logged_in', $loginState);
        $this->view->setTemplateBefore('public');
    }

    public function indexAction()
    {

    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {
        $form = new SignUpForm();

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) != false) {

                $user = new Users();

                $user->assign(array(
                    'name' => $this->request->getPost('name', 'striptags'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->security->hash($this->request->getPost('password')),
                    'profilesId' => 2
                ));

                if ($user->save()) {
                    return $this->dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                }

                $this->flash->error($user->getMessages());
            }
        }

        $this->view->form = $form;
    }

    /**
     * Starts a session in the admin backend
     */
    public function loginAction()
    {
        $form = new LoginForm();

        try {

            if (!$this->request->isPost()) {

                if ($this->auth->hasRememberMe()) {
                    return $this->auth->loginWithRememberMe();
                }
            } else {

                if ($form->isValid($this->request->getPost()) == false) {
                    foreach ($form->getMessages() as $message) {
                        $this->flash->error($message);
                    }
                } else {

                    $this->auth->check(array(
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'remember' => $this->request->getPost('remember')
                    ));

                    return $this->response->redirect('worldmap');
                }
            }
        } catch (AuthException $e) {
            $this->flash->error($e->getMessage());
        }

        $this->view->form = $form;
    }

    /**
     * Shows the forgot password form
     */
    public function forgotPasswordAction()
    {
        $form = new ForgotPasswordForm();

        if ($this->request->isPost()) {

            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flash->error($message);
                }
            } else {

                $user = Users::findFirstByEmail($this->request->getPost('email'));
                if (!$user) {
                    $this->flash->success('There is no account associated to this email');
                } else {

                    $resetPassword = new ResetPasswords();
                    $resetPassword->usersId = $user->id;
                    if ($resetPassword->save()) {
                        $this->flash->success('Success! Please check your messages for an email reset password');
                    } else {
                        foreach ($resetPassword->getMessages() as $message) {
                            $this->flash->error($message);
                        }
                    }
                }
            }
        }

        $this->view->form = $form;
    }

    /**
     * Closes the session
     */
    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('index');
    }
}
