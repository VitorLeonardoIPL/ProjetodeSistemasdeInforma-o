<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "localizacao".
 *
 * @property int $id
 * @property int $atribuicao_id
 * @property float $latitude
 * @property float $longitude
 * @property string $data_hora
 *
 * @property atribuicao $atribuicao
 */
class localizacao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'localizacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['atribuicao_id', 'latitude', 'longitude', 'data_hora'], 'required'],
            [['atribuicao_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['data_hora'], 'safe'],
            [['atribuicao_id'], 'exist', 'skipOnError' => true, 'targetClass' => atribuicao::class, 'targetAttribute' => ['atribuicao_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'atribuicao_id' => 'Atribuicao ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'data_hora' => 'Data Hora',
        ];
    }

    /**
     * Gets query for [[Atribuicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtribuicao()
    {
        return $this->hasOne(atribuicao::class, ['id' => 'atribuicao_id']);
    }

}
