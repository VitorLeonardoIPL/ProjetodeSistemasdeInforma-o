<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "necessidade_manutencao".
 *
 * @property int $id
 * @property int $viatura_id
 * @property int|null $orcamento_id
 * @property int $registada_por
 * @property string $tipo
 * @property string|null $descricao
 * @property string $data
 *
 * @property orcamento_compra $orcamento
 * @property User $registadaPor
 * @property viatura $viatura
 */
class necessidade_manutencao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'necessidade_manutencao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orcamento_id', 'descricao'], 'default', 'value' => null],
            [['viatura_id', 'registada_por', 'tipo', 'data'], 'required'],
            [['viatura_id', 'orcamento_id', 'registada_por'], 'integer'],
            [['data'], 'safe'],
            [['tipo', 'descricao'], 'string', 'max' => 255],
            [['orcamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => orcamento_compra::class, 'targetAttribute' => ['orcamento_id' => 'id']],
            [['registada_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['registada_por' => 'id']],
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
            'orcamento_id' => 'Orcamento ID',
            'registada_por' => 'Registada Por',
            'tipo' => 'Tipo',
            'descricao' => 'Descricao',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[Orcamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamento()
    {
        return $this->hasOne(orcamento_compra::class, ['id' => 'orcamento_id']);
    }

    /**
     * Gets query for [[RegistadaPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegistadaPor()
    {
        return $this->hasOne(User::class, ['id' => 'registada_por']);
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
