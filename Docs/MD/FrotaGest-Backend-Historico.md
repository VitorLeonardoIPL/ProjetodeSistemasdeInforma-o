# FrotaGest backend: o que foi feito (para fazer no futuro)

Registo do que foi feito no backend em 2026-10-29 e depois **desfeito** a pedido, porque por agora só são precisos os 4 itens do Dashboard (Viaturas, Viaturas disponíveis, Requisições pendentes, Condutores). Fica aqui para repetir mais tarde, sem refazer o trabalho de descobrir.

O manual passo a passo em HTML está em `Docs/Manuais_Estudos/FrotaGest-Backend-CRUDs-Manual.html` (tem também o RBAC, o seed e a versão atual do soft delete). Este ficheiro guarda sobretudo o código dos 21 CRUDs e dos utilizadores.

## 1. CRUDs das 21 tabelas com o Gii (linha de comandos)

Corre na pasta `FrotaGest`, no Git Bash. Usar **aspas simples** nas classes (em aspas duplas o Git Bash apaga as barras invertidas).

Um CRUD:

```bash
php yii gii/crud --modelClass='common\models\viatura' --controllerClass='backend\controllers\ViaturaController' --searchModelClass='backend\models\ViaturaSearch' --interactive=0 --overwrite=1
```

Todos os modelos de `common/models` (menos `User` e `LoginForm`):

```bash
for f in common/models/*.php; do
  m=$(basename $f .php)
  case $m in User|LoginForm) continue;; esac
  P=$(echo $m | sed -E 's/(^|_)([a-z])/\U\2/g')
  php yii gii/crud --modelClass='common\models\'$m --controllerClass='backend\controllers\'${P}Controller --searchModelClass='backend\models\'${P}Search --interactive=0 --overwrite=1
done
```

Cuidados que apareceram:

- **Vistas no sítio errado:** o comando corre na app de consola, por isso as vistas saem em `console/views/`. Mover para o backend: `cp -r console/views/* backend/views/ && rm -rf console/views`.
- **Nome da rota:** `ausencia_condutor` → `AusenciaCondutorController` → rota `ausencia-condutor/index`.
- **Chaves estrangeiras:** os formulários pedem o id (número), não o nome. Criar por ordem: categoria → viatura → condutor → requisicao → atribuicao → resto.
- Testei por script que as páginas `index` e `create` das 21 tabelas abrem sem erro. Não testei gravar registos em todas.

## 2. Login obrigatório nos controladores gerados

O Gii **não** põe controlo de acesso: sem isto qualquer pessoa sem login abre os CRUDs. Em cada controlador gerado, no `behaviors()` e com `use yii\filters\AccessControl;`:

```php
'access' => [
    'class' => AccessControl::className(),
    'rules' => [
        [
            'allow' => true,
            'roles' => ['@'],
        ],
    ],
],
```

Isto só pede login. **Falta** ligar os roles do RBAC (`acederBackoffice`, `gerirViaturas`, `gerirCondutores`…) ao `AccessControl`, e atribuir roles aos utilizadores.

## 3. Menu lateral (`backend/views/layouts/sidebar.php`)

O menu é o `Menu::widget` do `hail812/adminlte`. Itens com `'header'` são títulos de grupo. A rota é sempre `['/<controlador-com-hifens>/index']`. A versão completa tinha estes itens:

```php
'items' => [
                    ['label' => 'Dashboard', 'icon' => 'tachometer-alt', 'url' => ['/site/index']],

                    ['header' => 'FROTA'],
                    ['label' => 'Categorias', 'icon' => 'tags', 'url' => ['/categoria/index']],
                    ['label' => 'Viaturas', 'icon' => 'car', 'url' => ['/viatura/index']],
                    ['label' => 'Condutores', 'icon' => 'id-card', 'url' => ['/condutor/index']],
                    ['label' => 'Ausências de condutores', 'icon' => 'user-clock', 'url' => ['/ausencia-condutor/index']],

                    ['header' => 'REQUISIÇÕES'],
                    ['label' => 'Requisições', 'icon' => 'clipboard-list', 'url' => ['/requisicao/index']],
                    ['label' => 'Atribuições', 'icon' => 'link', 'url' => ['/atribuicao/index']],
                    ['label' => 'Checklists', 'icon' => 'check-square', 'url' => ['/checklist/index']],
                    ['label' => 'Anexos', 'icon' => 'paperclip', 'url' => ['/anexo/index']],
                    ['label' => 'Faturas de combustível', 'icon' => 'gas-pump', 'url' => ['/fatura-combustivel/index']],
                    ['label' => 'Localizações', 'icon' => 'map-marker-alt', 'url' => ['/localizacao/index']],

                    ['header' => 'MANUTENÇÃO'],
                    ['label' => 'Necessidades', 'icon' => 'exclamation-triangle', 'url' => ['/necessidade-manutencao/index']],
                    ['label' => 'Manutenções', 'icon' => 'tools', 'url' => ['/manutencao/index']],
                    ['label' => 'Peças', 'icon' => 'cog', 'url' => ['/peca/index']],
                    ['label' => 'Orçamentos de compra', 'icon' => 'file-invoice-dollar', 'url' => ['/orcamento-compra/index']],
                    ['label' => 'Itens de orçamento', 'icon' => 'list', 'url' => ['/item-orcamento/index']],

                    ['header' => 'AVISOS'],
                    ['label' => 'Alertas', 'icon' => 'bell', 'url' => ['/alerta/index']],
                    ['label' => 'Notificações', 'icon' => 'envelope', 'url' => ['/notificacao/index']],

                    ['header' => 'SISTEMA'],
                    ['label' => 'Utilizadores', 'icon' => 'users', 'url' => ['/user/index']],
                    ['label' => 'Perfis', 'icon' => 'user', 'url' => ['/perfil/index']],
                    ['label' => 'Parâmetros', 'icon' => 'sliders-h', 'url' => ['/parametro/index']],
                    ['label' => 'Serviços externos', 'icon' => 'plug', 'url' => ['/servico-externo/index']],
                    ['label' => 'Logs de auditoria', 'icon' => 'history', 'url' => ['/log-auditoria/index']],
                ],
```

## 4. Utilizadores com soft delete (versão simples)

Ideia: "apagar" um utilizador **não remove a linha**, só põe o `status` a 0 (`User::STATUS_DELETED`, constante que já vem no template). Mantém as chaves estrangeiras (`perfil`, `requisicao`). O login já só aceita `status = 10`, por isso a conta apagada deixa de entrar sem mexer no login.

Não há `softDelete()`, `restore()` nem botão de reativar. **Reativar** faz-se editando o utilizador e mudando o **Estado** para Ativo. (Não se usa `deleted_at`: ficou de parte.)

Ficheiros: `backend/controllers/UserController.php`, `backend/models/UserForm.php`, `backend/models/UserSearch.php`, `backend/views/user/{index,view,create,update,_form}.php`, mais o link `/user/index` no menu. No modelo `common/models/User.php` só é preciso o texto dos estados:

```php
    /**
     * Texto do estado da conta
     */
    public static function statusLabels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Ativo',
            self::STATUS_INACTIVE => 'Inativo',
            self::STATUS_DELETED => 'Apagado',
        ];
    }
```

Nota: o `UserSearch` estende `User`, por isso o seu `rules()` tem de ter `: array` (senão: `Declaration ... must be compatible`). O `php -l` não apanha isto, só correr a página.

O `UserForm` e a listagem já incluem o **role** (ver o manual HTML, passos 12 a 14). O código dos ficheiros é o atual:

### backend/controllers/UserController.php

```php
<?php

namespace backend\controllers;

use backend\models\UserForm;
use backend\models\UserSearch;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController: CRUD de utilizadores com soft delete (delete so muda o status)
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                //controlo de acesso: cada action pede a permissao do RBAC
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['index', 'view', 'create', 'update', 'delete'],
                            'roles' => ['gerirUtilizadores'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new UserForm();
        if ($model->load($this->request->post()) && ($user = $model->save())) {
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = new UserForm($this->findModel($id));
        if ($model->load($this->request->post()) && ($user = $model->save())) {
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'id' => $id,
        ]);
    }

    //soft delete: a conta nao sai da BD, passa a status apagado
    public function actionDelete($id)
    {
        //ninguem apaga a propria conta
        if ($id == Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'Nao podes apagar a tua propria conta.');

            return $this->redirect(['index']);
        }
        $user = $this->findModel($id);
        $user->status = User::STATUS_DELETED;
        $user->save(false, ['status', 'updated_at']);

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
```

### backend/models/UserForm.php

```php
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
```

### backend/models/UserSearch.php

```php
<?php

namespace backend\models;

use common\models\perfil;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Pesquisa de utilizadores para a listagem
 */
class UserSearch extends User
{
    //o role esta no perfil, nao na tabela user
    public $role;

    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email', 'role'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find()->with('perfil');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id, 'status' => $this->status]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        //filtrar pelo role: so os utilizadores cujo perfil tem esse role
        if ($this->role) {
            $query->andWhere(['id' => perfil::find()->select('user_id')->where(['role' => $this->role])]);
        }

        return $dataProvider;
    }
}
```

### backend/views/user/index.php

```php
<?php

use backend\models\UserForm;
use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Utilizadores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger"><?= Html::encode(Yii::$app->session->getFlash('error')) ?></div>
    <?php endif; ?>

    <p>
        <?= Html::a('Criar utilizador', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email',
            [
                'attribute' => 'role',
                'label' => 'Role',
                //o role esta guardado no perfil do utilizador
                'value' => function ($model) {
                    return $model->perfil ? $model->perfil->role : null;
                },
                'filter' => UserForm::roleList(),
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return User::statusLabels()[$model->status];
                },
                'filter' => User::statusLabels(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    //soft delete: so aparece nas contas que ainda nao estao apagadas
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash"></i>', Url::to(['delete', 'id' => $model->id]), [
                            'title' => 'Apagar (soft delete)',
                            'data-method' => 'post',
                            'data-confirm' => 'Apagar este utilizador? A conta fica com o estado Apagado (para a reativar, edita o Estado).',
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'delete' => function ($model) {
                        return $model->status != User::STATUS_DELETED;
                    },
                ],
            ],
        ],
    ]); ?>

</div>
```

### backend/views/user/view.php

```php
<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if ($model->status != User::STATUS_DELETED): ?>
            <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apagar este utilizador? A conta fica com o estado Apagado (para a reativar, edita o Estado).',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email',
            [
                'label' => 'Role',
                'value' => $model->perfil ? $model->perfil->role : null,
            ],
            [
                'attribute' => 'status',
                'value' => User::statusLabels()[$model->status],
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
```

### backend/views/user/_form.php

```php
<?php

use backend\models\UserForm;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\UserForm $model */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //autocomplete: impede o browser de preencher o username e a password com o login guardado ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'new-password'])->hint('Ao editar, deixa vazio para manter a password atual.') ?>

    <?= $form->field($model, 'role')->dropDownList(UserForm::roleList(), ['prompt' => 'Escolher role...'])->hint('O role decide o que a pessoa pode fazer no sistema.') ?>

    <?= $form->field($model, 'status')->dropDownList(User::statusLabels()) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
```

### backend/views/user/create.php

```php
<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\UserForm $model */

$this->title = 'Criar utilizador';
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
```

### backend/views/user/update.php

```php
<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\UserForm $model */
/** @var int $id */

$this->title = 'Editar utilizador: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
```

Testado por HTTP real (login com o Admin): apagar põe o `status` a 0 e a linha fica; o login dessa conta é recusado; a listagem mostra "Apagado" e esconde o botão do lixo; reativar pelo formulário (Estado = Ativo) repõe o login e mantém o role; apagar a própria conta é recusado; o delete por GET dá 405.

## 5. Ideias para depois

- Ligar o RBAC: `acederBackoffice` no backend e uma permissão por CRUD.
- Dropdowns com nome nas chaves estrangeiras (`categoria_id`, `utilizador_id`…) e `estado` como lista.
- Preencher `data_pedido` sozinha; validar duração máxima e antecedência das requisições (parâmetros já na BD).
- Ligar os "More info" das caixas do Dashboard aos CRUDs.
- Atribuir roles aos utilizadores na gestão de utilizadores.
