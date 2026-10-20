<?php

namespace common\rbac;

use yii\rbac\Rule;

/**
 * Verifica se a requisicao pertence ao utilizador autenticado
 */
class IsRequisicaoOwnerRule extends Rule
{
    public $name = 'isRequisicaoOwner';

    //$user: id do utilizador, $params: o que vai em can('x', ['requisicao' => $model])
    public function execute($user, $item, $params)
    {
        return isset($params['requisicao']) ? $params['requisicao']->user_id == $user : false;
    }
}
