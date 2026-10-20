<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ausencia_condutor".
 *
 * @property int $id
 * @property int $condutor_id
 * @property string $data_inicio
 * @property string $data_fim
 * @property string|null $motivo
 *
 * @property Condutor $condutor
 */
class ausencia_condutor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ausencia_condutor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['motivo'], 'default', 'value' => null],
            [['condutor_id', 'data_inicio', 'data_fim'], 'required'],
            [['condutor_id'], 'integer'],
            [['data_inicio', 'data_fim'], 'safe'],
            [['motivo'], 'string', 'max' => 255],
            [['condutor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condutor::class, 'targetAttribute' => ['condutor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'condutor_id' => 'Condutor ID',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
            'motivo' => 'Motivo',
        ];
    }

    /**
     * Gets query for [[Condutor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCondutor()
    {
        return $this->hasOne(Condutor::class, ['id' => 'condutor_id']);
    }

}
