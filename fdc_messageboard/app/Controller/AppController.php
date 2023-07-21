<?php

App::uses('Controller', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('SessionComponent', 'Controller/Component');

class AppController extends Controller {
    
    public $components = array(
        'DebugKit.Toolbar',
        'Session',
        'Flash',
        'Auth' =>
        array(
            'loginRedirect' => array('controller' => 'Users', 'action' => 'profile'),
            'logoutRedirect' => array('controller' => 'Users','action' => 'login','plugin' => false),
        //     'authorize' => array('Controller'), // Add the 'authorize' option here
        //     'authenticate' => array(
        //         'Form' => array(
        //             'fields' => array('username' => 'username', 'password' => 'password')
        //         )
        //     )
        //     // ),
        //     // 'authError' => 'Please login first!',
        )
    );

    public function beforeFilter() {
        // parent::beforeFilter();
        // if ($this->name === 'CakeError' && 'isset'($this->request->params['plugin']) && $this->request->params['plugin'] === 'DebugKit') {
        //     return true;
        // }
        $this->Auth->allow('login','register', 'thankyou','login_request', 'authenticateUser', 'logout'); // Add other actions that are allowed
       
    }

    // public function isAuthorized($user){
    //         return true;
    // }
}

