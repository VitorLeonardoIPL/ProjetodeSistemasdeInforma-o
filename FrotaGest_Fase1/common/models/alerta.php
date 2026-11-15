<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "alerta".
 *
 * @property int $id
 * @property int $viatura_id
 * @property string $tipo
 * @property string|null $descricao
 * @property string|null $data_limite
 * @property string $data_geracao
 * @property string $estado
 *
 * @property notificacao[] $notificacaos
 * @property viatura $viatura
 */
class alerta extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alerta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao', 'data_limite'], 'default', 'value' => null],
            [['viatura_id', 'tipo', 'data_geracao', 'estado'], 'required'],
            [['viatura_id'], 'integer'],
            [['data_limite', 'data_geracao'], 'safe'],
            [['tipo', 'descricao', 'estado'], 'string', 'max' => 255],
            [['viatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => viatura::class, 'targetAttribute' => ['viatura_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'viatura_id' => 'Viatura ID',
            'tipo' => 'Tipo',
            'descricao' => 'Descricao',
            'data_limite' => 'Data Limite',
            'data_geracao' => 'Data Geracao',
            'estado' => 'Estado',
        ];
    }

    /**
     * Gets query for [[Notificacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificacaos()
    {
        return $this->hasMany(notificacao::class, ['alerta_id' => 'id']);
    }

    /**
     * Gets query for [[Viatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViatura()
    {
        return $this->hasOne(viatura::class, ['id' => 'viatura_id']);
    }

}
