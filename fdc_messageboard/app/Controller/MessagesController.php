<?php
App::uses('SessionComponent', 'Controller/Component');
class MessagesController extends AppController
{
    public $helpers = array('Html', 'Form');
    public $components = array('RequestHandler');
    public function beforeFilter()
    {
        parent::beforeFilter();

        // Check the session condition
        if ($this->Session->read('logged_in') == true) {
            // Disable the specific action(s)
            $this->Auth->allow('contact', 'view_message', 'sent_message','search_contact','delete_message', 'deleteAllmessage');
        }
    }

    function search_contact(){
        $this->loadModel('User');
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $search = $this->request->data;
            $results = $this->User->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        array('User.name LIKE' => '%' . $search['search'] . '%'),
                        array('User.email LIKE' => '%' . $search['search'] . '%')
                    ),
                    'AND' =>array(
                        array('User.id !='.$this->Session->read('user_id')),
                    )
                )
            ));
            echo json_encode($results);
            exit;
        }
    }

    public function contact()
    {
        $this->set('messages', $this->Message->find('all', array(
            'conditions' => array(
                'OR' => array(
                    array('message_to' => $this->Session->read('user_id')),
                    array('message_from' => $this->Session->read('user_id'))
                )
            ),
            'joins' => array(
                array(
                    'table' => 'Users',
                    'type' => 'INNER',
                    'conditions' => array(
                        'OR' => array(
                            'Users.id = Message.message_from',
                            'Users.id = Message.message_to',
                        ),
                        'AND' => array(
                            'Users.id !=' => $this->Session->read('user_id')
                        )
                    )
                )
            ),
            'fields' => array('Users.name, Users.profile_img, Users.id'),
            'group' => array('Users.id')
        )));
    }

    function view_message()
    {
        if ($this->request->is('ajax')) {
            $this->loadModel('User');
            $this->autoRender = false;
            $data = $this->request->data;

            $perPage = 10; // Number of items to load per page
            $offset = ($data['page'] - 1) * $perPage;

            $messages = $this->Message->find('all', [
                'limit' => $perPage,
                'offset' => $offset,
                'conditions' => array(
                    'OR' => array(
                        array(
                            'AND' => array(
                                array('message_to' => $this->Session->read('user_id')),
                                array('message_from' => $data['user_id'])
                            ),
                        ),
                        array(
                            'AND' => array(
                                array('message_to' => $data['user_id']),
                                array('message_from' => $this->Session->read('user_id'))
                            )
                        )
                    ),
                ),
                'order' => array(
                    'Message.id' => 'desc', // Sort by 'column1' in ascending order
                    // 'column2' => 'desc' // Sort by 'column2' in descending order
                )
            ]);
            $contact_info = $this->User->find('all', [
                'conditions' => array(
                    array('User.id' => $data['user_id'])
                ),
                'fields' => array('User.name, User.profile_img, User.id'),
            ]);

            foreach ($messages as $key => $message) {
                if ($message['Message']['message_from'] ==  $data['user_id'] || $message['Message']['message_to'] ==  $data['user_id']) {
                    $contact_message['contact'] = $contact_info[0]['User'];
                    $contact_message['my_profile'] = $this->Session->read('profile_pic');
                    $contact_message['messages'][] = $message['Message'];
                }
            }
            // $this->autoRender = false;
            // $this->response->type('json');
            echo json_encode($contact_message);
            exit;
        }
    }

    function sent_message()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $data = $this->request->data;
            $insert['Message']['content'] = $data['message'];
            $insert['Message']['message_from'] = $this->Session->read('user_id');
            $insert['Message']['message_to'] = $data['user_id'];
            $insert['Message']['sent_date'] = date('Y-m-d H:i:s');
            if ($this->Message->save($insert)) {
                // Data saved successfully
                $response['message_id'] = $this->Message->id;
                $response['message'] = $data['message'];
                $response['sent_date'] = $insert['Message']['sent_date'];
                $response['my_profile'] = $this->Session->read('profile_pic');
                $response['success'] = true;
            } else {
                $response['message'] = "Something went wrong, please try again.";
                $response['success'] = false;
            }
            echo json_encode($response);
            exit;
        }
    }
    function delete_message(){
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $data = $this->request->data;
            $conditions = array('Message.id' => $data['message_id']);
            if($this->Message->deleteAll($conditions)){
                $response['icon'] = 'success';
                $response['message'] = 'Successfully deleted.';
                $response['success'] =true;
            } else {
                $response['icon'] = 'error';
                $response['message'] = 'Something went wrong.';
                $response['success'] =false;
            }
            echo json_encode($response);
            exit;
        }
    }

    function deleteAllmessage(){
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $data = $this->request->data;
            $conditions = array(
                'OR' => array(
                    array(
                        'AND' => array(
                            'message_from' => $data['user_id'],
                            'message_to' => $this->Session->read('user_id')
                            )
                        ),
                    array(
                        'AND' => array(
                            'message_to' => $data['user_id'],
                            'message_from' =>$this->Session->read('user_id'),
                        )
                    )
                )
            );
            if($this->Message->deleteAll($conditions)){
                $response['success'] =true;
            } else {
                $response['icon'] = 'error';
                $response['message'] = 'Something went wrong.';
                $response['success'] =false;
            }
        }
        echo json_encode($response);
        exit;
    }
}
