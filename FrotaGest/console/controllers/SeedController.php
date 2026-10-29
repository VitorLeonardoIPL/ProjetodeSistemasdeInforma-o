<?php

namespace console\controllers;

use common\models\perfil;
use common\models\User;
use Yii;
use yii\console\Controller;

/**
 * Utilizadores de teste ligados ao RBAC. So para desenvolvimento: apagar mais tarde.
 */
class SeedController extends Controller
{
    // php yii seed/init (depois de php yii migrate e php yii rbac/init)
    public function actionInit()
    {
        //ponto de acesso ao RBAC: o componente authManager (common/config/main.php)
        $auth = Yii::$app->authManager;

        //utilizadores de teste: username => [email, role]
        $utilizadores = [
            'Admin' => ['admin@ulo.pt', 'administrador'],
            'coordenador' => ['coordenador@ulo.pt', 'coordenador'],
            'tecnico' => ['tecnico@ulo.pt', 'tecnico'],
            'colaborador' => ['colaborador@ulo.pt', 'colaborador'],
        ];

        //os roles tem de existir: foram criados pelo rbac/init
        foreach ($utilizadores as $dados) {
            if (!$auth->getRole($dados[1])) {
                echo "O role {$dados[1]} nao existe. Corre primeiro: php yii rbac/init\n";
                return;
            }
        }

        foreach ($utilizadores as $username => $dados) {
            //utilizador, perfil e role gravam juntos; se um falhar, nenhum fica gravado
            $transacao = Yii::$app->db->beginTransaction();
            try {
                //se o utilizador ja existe nao o duplica nem muda a password
                $user = User::findOne(['username' => $username]);
                $estado = 'ja existia';
                if (!$user) {
                    $user = new User();
                    $user->username = $username;
                    $user->email = $dados[0];
                    $user->setPassword('12345678');
                    $user->generateAuthKey();
                    $user->status = User::STATUS_ACTIVE;
                    $user->save(false);
                    $estado = 'criado';
                }

                //o perfil guarda o role (copia para consulta); o nome fica igual ao username
                $perfil = perfil::findOne(['user_id' => $user->id]);
                if (!$perfil) {
                    $perfil = new perfil(['user_id' => $user->id, 'nome' => $username]);
                }
                $perfil->role = $dados[1];
                $perfil->save();

                //o acesso decide-se pela auth_assignment: um so role por utilizador
                $auth->revokeAll($user->id);
                $auth->assign($auth->getRole($dados[1]), $user->id);

                $transacao->commit();
                echo "$username ($estado): role {$dados[1]}\n";
            } catch (\Throwable $e) {
                $transacao->rollBack();
                echo "$username: erro ({$e->getMessage()})\n";
            }
        }

        echo "Utilizadores de teste prontos. Password de todos: 12345678\n";
    }
}
