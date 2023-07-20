<?php

class User extends AppModel
{

    public $validate = [
        'name' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'Name is required'
            ],
            'length' => [
                'rule' => ['lengthBetween', 6, 20],
                'message' => 'Name must be between 6 and 20 characters.'
            ]
        ],
        'email' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                'message' => 'Please enter a valid email address',
            ],
            'unique' => [
                'rule' => 'isUnique',
                'message' => 'Email has already been taken.',
                'on'    => 'create'
            ],
            'validEmail' => [
                'rule' => 'email',
                'message' => 'Please enter a valid email address.',
            ],
        ],
        'password' => [
            'minLength' => [
                'rule' => ['minLength', 6],
                'required' => true,
                'message' => 'Password must be at least 6 characters long',
            ]
        ],
        'confirm_password' => [
            'compareFields' => [
                'rule' => ['compareFields', 'password'],
                'required' => true,
                'message' => 'Passwords do not match',
            ]
        ]
    ];

    public function beforeValidate($options = array())
    {
        if (!isset($this->data[$this->alias]['password'])) {
            unset($this->validate['password']);
            unset($this->validate['confirm_password']);
        }
        return true;
    }

    public function compareFields($data)
    {

        if ($this->data['User']['password'] === $data['confirm_password']) {
            return true;
        }
        $this->invalidate('password', 'Password do not match.');
        return false;
    }

    public function beforeSave($options = array())
    {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    public function validateEmail($check)
    {
        $email = $check;
       
        $previousEmail = $this->data[$this->alias]['previous_email'];
        $conditions = [
            $this->alias . '.email' => $email,
            'NOT' => [
                $this->alias . '.email' => $previousEmail,
            ],
        ];
        $count = $this->find('count', [
            'conditions' => $conditions,
        ]);
        if ($count !== 0) {
            return 'This email address is already taken.';
        }
        return true;
    }
}
