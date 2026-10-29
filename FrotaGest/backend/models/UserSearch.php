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
