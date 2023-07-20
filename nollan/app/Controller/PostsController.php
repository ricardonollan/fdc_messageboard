<?php
App::uses('SessionComponent', 'Controller/Component');
class PostsController extends AppController
{
    public function beforeFilter() {
        parent::beforeFilter();
        
        // Check the session condition
        if ($this->Session->read('logged_in') == true) {
            // Disable the specific action(s)
            $this->Auth->allow('index', 'view');
        }
    }
    public $helpers = array('Html', 'Form');
    public function index()
    {
        $this->set('posts', $this->Post->find('all'));
    }

    public function view($id = null){
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }
}
