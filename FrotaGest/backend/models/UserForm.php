<?php

namespace backend\models;

use common\models\perfil;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Formulario de criar/editar utilizador no backend
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;
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
            //o role atual vem do authManager (tabela auth_assignment)
            $roles = Yii::$app->authManager->getRolesByUser($this->_user->id);
            $this->role = $roles ? array_keys($roles)[0] : null;
        } else {
            $this->status = User::STATUS_ACTIVE;
        }
        parent::__construct($config);
    }

    //os roles que existem no RBAC (criados pelo RbacController)
    public static function roleList()
    {
        $lista = [];
        foreach (Yii::$app->authManager->getRoles() as $role) {
            $lista[$role->name] = $role->name;
        }

        return $lista;
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'status', 'role'], 'required'],
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
            ['role', 'in', 'range' => array_keys(self::roleList())],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
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

        //utilizador, perfil e role gravam juntos; se um falhar, nenhum fica gravado
        $transacao = Yii::$app->db->beginTransaction();
        try {
            $user->save(false);

            //o perfil e obrigatorio ter nome: ao criar, usa o username
            $perfil = perfil::findOne(['user_id' => $user->id]);
            if (!$perfil) {
                $perfil = new perfil(['user_id' => $user->id, 'nome' => $user->username]);
            }
            $perfil->role = $this->role;
            if (!$perfil->save()) {
                throw new \Exception('Perfil invalido');
            }

            //o acesso decide-se pela auth_assignment: tira o role anterior e atribui o novo
            $auth = Yii::$app->authManager;
            $auth->revokeAll($user->id);
            $auth->assign($auth->getRole($this->role), $user->id);

            $transacao->commit();
        } catch (\Throwable $e) {
            $transacao->rollBack();
            $this->addError('role', 'Nao foi possivel gravar o utilizador.');

            return null;
        }

        return $user;
    }
}
