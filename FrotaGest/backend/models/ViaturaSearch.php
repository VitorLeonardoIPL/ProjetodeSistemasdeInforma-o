<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\viatura;

/**
 * ViaturaSearch represents the model behind the search form of `common\models\viatura`.
 */
class ViaturaSearch extends viatura
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'categoria_id', 'km_atual'], 'integer'],
            [['matricula', 'marca', 'modelo', 'combustivel', 'caracteristicas', 'foto', 'qr_code', 'estado'], 'safe'],
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
        $query = viatura::find();

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
            'categoria_id' => $this->categoria_id,
            'km_atual' => $this->km_atual,
        ]);

        $query->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'marca', $this->marca])
            ->andFilterWhere(['like', 'modelo', $this->modelo])
            ->andFilterWhere(['like', 'combustivel', $this->combustivel])
            ->andFilterWhere(['like', 'caracteristicas', $this->caracteristicas])
            ->andFilterWhere(['like', 'foto', $this->foto])
            ->andFilterWhere(['like', 'qr_code', $this->qr_code])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
