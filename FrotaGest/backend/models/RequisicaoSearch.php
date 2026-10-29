<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\requisicao;

/**
 * RequisicaoSearch represents the model behind the search form of `common\models\requisicao`.
 */
class RequisicaoSearch extends requisicao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'utilizador_id', 'categoria_id'], 'integer'],
            [['data_inicio', 'data_fim', 'destino', 'motivo', 'estado', 'motivo_recusa', 'data_pedido'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = requisicao::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'utilizador_id' => $this->utilizador_id,
            'categoria_id' => $this->categoria_id,
            'data_inicio' => $this->data_inicio,
            'data_fim' => $this->data_fim,
            'data_pedido' => $this->data_pedido,
        ]);

        $query->andFilterWhere(['like', 'destino', $this->destino])
            ->andFilterWhere(['like', 'motivo', $this->motivo])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'motivo_recusa', $this->motivo_recusa]);

        return $dataProvider;
    }
}
