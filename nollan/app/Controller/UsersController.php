
<?php
App::uses('SessionComponent', 'Controller/Component');
class UsersController extends AppController
{
    public $helpers = array('Html', 'Form');
    public function beforeFilter()
    {
        parent::beforeFilter();

        // Check the session condition
        if ($this->Session->read('logged_in') == true) {
            // Disable the specific action(s)
            $this->Auth->allow('profile', 'editProfile', 'updateProfile');
        }
    }

    public function login()
    {
        // if ($this->request->is('post')) {

        //     if ($this->Auth->login()) {
        //         $response['success'] = true;
        //     } else {
        //         $response['success' ] = false;
        //         $response['message' ] = 'Invalid email or password.';
        //         echo json_encode($response);
        //         $this->autoRender = false;
        //         $this->response->type('json');
        //     }
        // }
    }

    function authenticateUser($email, $password)
    {
        $user_data = $this->User->findByEmail($email);
        if (isset($user_data) && !empty($user_data)) {
            if ($user_data['User']['password'] == AuthComponent::password($password)) {
                $this->Session->write('user_id', $user_data['User']['id']);
                $this->Session->write('user', $user_data['User']['name']);
                $this->Session->write('user_email', $user_data['User']['email']);
                $this->Session->write('profile_pic', $user_data['User']['profile_img']);
                $this->User->id = $user_data['User']['id'];
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function login_request()
    {
        $data = $this->request->data;
        if ($this->request->is('post')) {
            if ($this->authenticateUser($data['User']['email'], $data['User']['password'])) {
                // Authentication successful
                $this->Session->write('logged_in', true);
                $response['success'] = true;
            } else {
                // Authentication failed
                $response['success'] = false;
                $response['message'] = 'Invalid email or password.';
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Invalid request method.'
            );
        }

        $this->autoRender = false;
        $this->response->type('json');
        echo json_encode($response);
        exit;
    }

    public function logout()
    {
        $this->Session->destroy();
        $this->redirect($this->Auth->logout());
    }
    public function register()
    {
        if ($this->request->is('post')) {
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                $this->request->data['User']['joined_date'] = date('Y-m-d H:i:s');
                $this->request->data['User']['last_login'] = date('Y-m-d H:i:s');
                if ($this->User->save($this->request->data)) {
                    $this->Flash->success('User registered successfully.');
                    $this->Session->write('logged_in', true);
                    $this->Session->write('user_id', $this->User->getLastInsertID());
                    $this->Session->write('user', $this->request->data['User']['name']);
                    $this->Session->write('user_email', $this->request->data['User']['email']);
                    $this->redirect(array('controller' => 'Users', 'action' => 'thankyou'));
                } else {
                    // debug($this->User->validationErrors); // Display any save errors
                    $this->Flash->error('Failed to save user.');
                }
            } else {
                // debug($this->User->validationErrors); // Display validation errors
                $this->Flash->error('Please fill out all needed information below.');
            }
        }
    }
    public function thankyou()
    {
    }

    public function profile()
    {
        $this->set('users', $this->User->find('all'));
    }

    function updateProfile()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $data = $this->request->data;

            if (isset($data['User']['email'])) {
                unset($this->User->validate['email']['unique']);
            }
            
            $this->User->set($data); // Set the data to the model for validation
            $this->User->data['User']['previous_email'] = $this->Session->read('user_email');

            $validate_email = $this->User->validateEmail($data['User']['email']);
           
            if ($validate_email === true) {
                if ($this->User->validates()) {
                    if($this->request->data['User']['profile']['tmp_name']){
                        $targetDir = WWW_ROOT . 'img/';
                        $data['User']['profile_img'] = $data['User']['name'].date('y-m-d').'.'.pathinfo($this->request->data['User']['profile']['name'], PATHINFO_EXTENSION);
                        move_uploaded_file($this->request->data['User']['profile']['tmp_name'], $targetDir . $data['User']['profile_img']);
                        $this->User->updateAll(
                            array(
                                'User.profile_img' => "'" . $data['User']['profile_img'] . "'",
                                'User.hubby' => "'" . $data['User']['hubby'] . "'",
                                'User.name' => "'" . $data['User']['name'] . "'",
                                'User.email' => "'" . $data['User']['email'] . "'",
                                'User.gender' => "'" . $data['User']['gender'] . "'",
                                'User.birthdate' => "'" . date('Y-m-d', strtotime($data['User']['birthdate'])) . "'"
                            ),
                            array('User.id' => $this->Session->read('user_id'))
                        );
                    } else {
                        $data['User']['profile_img'] = '';
                        $this->User->updateAll(
                            array(
                                'User.hubby' => "'" . $data['User']['hubby'] . "'",
                                'User.name' => "'" . $data['User']['name'] . "'",
                                'User.email' => "'" . $data['User']['email'] . "'",
                                'User.gender' => "'" . $data['User']['gender'] . "'",
                                'User.birthdate' => "'" . date('Y-m-d', strtotime($data['User']['birthdate'])) . "'"
                            ),
                            array('User.id' => $this->Session->read('user_id'))
                        );
                    }
                    $this->Session->write('user_email', $data['User']['email']);
                    $this->Session->write('profile_pic', $data['User']['profile_img']);
                    $response['success'] = true;
                } else {
                    $response['success'] = false;
                    $response['message'] =  $this->User->validationErrors;
                }
            } else {
                $this->User->invalidate('email', $validate_email);
                $errors = $this->User->validationErrors;
                $response['success'] = false;
                $response['message'] = $errors['email'][0];
            }
            $this->autoRender = false;
            $this->response->type('json');
            echo json_encode($response);
            exit;
        }
    }
    public function editProfile()
    {
        $this->set('user', $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Session->read('user_id'),
            )
        )));
    }
}
