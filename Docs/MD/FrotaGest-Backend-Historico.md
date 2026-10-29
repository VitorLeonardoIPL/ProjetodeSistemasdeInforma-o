# FrotaGest backend: o que foi feito (para fazer no futuro)

Registo do que foi feito no backend em 2026-10-29 e depois **desfeito** a pedido, porque por agora só são precisos os 4 itens do Dashboard (Viaturas, Viaturas disponíveis, Requisições pendentes, Condutores). Fica aqui para repetir mais tarde, sem refazer o trabalho de descobrir.

O manual passo a passo em HTML está em `Docs/FrotaGest-Backend-CRUDs-Manual.html` (descreve a versão completa, com os 21 CRUDs).

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

## 4. Utilizadores com soft delete

Ideia: "apagar" um utilizador muda `status` para `0` (`User::STATUS_DELETED`) em vez de remover a linha. Mantém as chaves estrangeiras (`perfil`, `requisicao`) e permite reativar. Não foi preciso mexer no login: `User::findByUsername()` e `findIdentity()` já só aceitam `status = 10`.

Ficheiros criados: `backend/controllers/UserController.php`, `backend/models/UserForm.php`, `backend/models/UserSearch.php`, `backend/views/user/{index,view,create,update,_form}.php`, mais o link `/user/index` no menu. Alteração ao modelo `common/models/User.php`:

```diff
@@ -209,4 +209,36 @@ class User extends ActiveRecord implements IdentityInterface
     }
 
+    /**
+     * Soft delete: a conta fica na BD com status apagado (as FKs de perfil e requisicao mantem-se)
+     */
+    public function softDelete(): bool
+    {
+        $this->status = self::STATUS_DELETED;
+
+        return $this->save(false, ['status', 'updated_at']);
+    }
+
+    /**
+     * Reativa uma conta apagada
+     */
+    public function restore(): bool
+    {
+        $this->status = self::STATUS_ACTIVE;
+
+        return $this->save(false, ['status', 'updated_at']);
+    }
+
+    /**
+     * Texto do estado da conta
+     */
+    public static function statusLabels(): array
+    {
+        return [
+            self::STATUS_ACTIVE => 'Ativo',
+            self::STATUS_INACTIVE => 'Inativo',
+            self::STATUS_DELETED => 'Apagado',
+        ];
+    }
+
     /**
      * Removes password reset token
```

Nota: o `UserSearch` estende `User`, por isso o seu `rules()` tem de ter `: array` (senão: `Declaration ... must be compatible`). O `php -l` não apanha isto, só correr a página.

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
                //so utilizadores com login entram
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'restore' => ['POST'],
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
        $this->findModel($id)->softDelete();

        return $this->redirect(['index']);
    }

    //reativar uma conta apagada
    public function actionRestore($id)
    {
        $this->findModel($id)->restore();

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
```

### backend/models/UserSearch.php

```php
<?php

namespace backend\models;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Pesquisa de utilizadores para a listagem
 */
class UserSearch extends User
{
    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

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

        return $dataProvider;
    }
}
```

### backend/views/user/index.php

```php
<?php

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
                'attribute' => 'status',
                'value' => function ($model) {
                    return User::statusLabels()[$model->status];
                },
                'filter' => User::statusLabels(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {restore}',
                'buttons' => [
                    //soft delete: so aparece nas contas que ainda nao estao apagadas
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash"></i>', Url::to(['delete', 'id' => $model->id]), [
                            'title' => 'Apagar (soft delete)',
                            'data-method' => 'post',
                            'data-confirm' => 'Apagar este utilizador? A conta fica desativada e pode ser reativada.',
                        ]);
                    },
                    //reativar: so aparece nas contas apagadas
                    'restore' => function ($url, $model) {
                        return Html::a('<i class="fas fa-undo"></i>', Url::to(['restore', 'id' => $model->id]), [
                            'title' => 'Reativar',
                            'data-method' => 'post',
                        ]);
                    },
                ],
                'visibleButtons' => [
                    'delete' => function ($model) {
                        return $model->status != User::STATUS_DELETED;
                    },
                    'restore' => function ($model) {
                        return $model->status == User::STATUS_DELETED;
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
        <?php if ($model->status == User::STATUS_DELETED): ?>
            <?= Html::a('Reativar', ['restore', 'id' => $model->id], [
                'class' => 'btn btn-success',
                'data' => ['method' => 'post'],
            ]) ?>
        <?php else: ?>
            <?= Html::a('Apagar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apagar este utilizador? A conta fica desativada e pode ser reativada.',
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

use common\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\models\UserForm $model */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput()->hint('Ao editar, deixa vazio para manter a password atual.') ?>

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

Testado por script: criar, soft delete (a linha fica e o login falha), reativar, username duplicado recusado, editar sem mudar a password, e as 4 vistas a abrir.

## 5. Ideias para depois

- Ligar o RBAC: `acederBackoffice` no backend e uma permissão por CRUD.
- Dropdowns com nome nas chaves estrangeiras (`categoria_id`, `utilizador_id`…) e `estado` como lista.
- Preencher `data_pedido` sozinha; validar duração máxima e antecedência das requisições (parâmetros já na BD).
- Ligar os "More info" das caixas do Dashboard aos CRUDs.
- Atribuir roles aos utilizadores na gestão de utilizadores.
