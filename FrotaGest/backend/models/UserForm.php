<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;

/**
 * Formulario de criar/editar utilizador no backend
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;

    private $_user;

    //sem $user = utilizador novo; com $user = a editar
    public function __construct($user = null, $config = [])
    {
        $this->_user = $user ?: new User();
        if (!$this->_user->isNewRecord) {
            $this->username = $this->_user->username;
            $this->email = $this->_user->email;
            $this->status = $this->_user->status;
        } else {
            $this->status = User::STATUS_ACTIVE;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'status'], 'required'],
            [['username', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            //unico, ignorando o proprio utilizador quando se edita
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => function ($query) {
                if (!$this->_user->isNewRecord) {
                    $query->andWhere(['not', ['id' => $this->_user->id]]);
                }
            }],
            //a password so e obrigatoria ao criar
            ['password', 'required', 'when' => function () {
                return $this->_user->isNewRecord;
            }],
            ['password', 'string', 'min' => 8],
            ['status', 'in', 'range' => array_keys(User::statusLabels())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Estado',
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = $this->_user;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $this->status;
        //so muda a password se foi escrita uma nova
        if ($this->password) {
            $user->setPassword($this->password);
        }
        if ($user->isNewRecord) {
            $user->generateAuthKey();
        }

        return $user->save(false) ? $user : null;
    }
}
