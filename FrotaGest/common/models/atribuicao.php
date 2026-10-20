<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "atribuicao".
 *
 * @property int $id
 * @property int $requisicao_id
 * @property int $viatura_id
 * @property int $condutor_id
 * @property int $aprovada_por
 * @property string $data_atribuicao
 *
 * @property User $aprovadaPor
 * @property Checklist[] $checklists
 * @property Condutor $condutor
 * @property FaturaCombustivel[] $faturaCombustivels
 * @property Localizacao[] $localizacaos
 * @property Requisicao $requisicao
 * @property Viatura $viatura
 */
class atribuicao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atribuicao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requisicao_id', 'viatura_id', 'condutor_id', 'aprovada_por', 'data_atribuicao'], 'required'],
            [['requisicao_id', 'viatura_id', 'condutor_id', 'aprovada_por'], 'integer'],
            [['data_atribuicao'], 'safe'],
            [['aprovada_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['aprovada_por' => 'id']],
            [['condutor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Condutor::class, 'targetAttribute' => ['condutor_id' => 'id']],
            [['requisicao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requisicao::class, 'targetAttribute' => ['requisicao_id' => 'id']],
            [['viatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Viatura::class, 'targetAttribute' => ['viatura_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'requisicao_id' => 'Requisicao ID',
            'viatura_id' => 'Viatura ID',
            'condutor_id' => 'Condutor ID',
            'aprovada_por' => 'Aprovada Por',
            'data_atribuicao' => 'Data Atribuicao',
        ];
    }

    /**
     * Gets query for [[AprovadaPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAprovadaPor()
    {
        return $this->hasOne(User::class, ['id' => 'aprovada_por']);
    }

    /**
     * Gets query for [[Checklists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChecklists()
    {
        return $this->hasMany(Checklist::class, ['atribuicao_id' => 'id']);
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

    /**
     * Gets query for [[FaturaCombustivels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFaturaCombustivels()
    {
        return $this->hasMany(FaturaCombustivel::class, ['atribuicao_id' => 'id']);
    }

    /**
     * Gets query for [[Localizacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocalizacaos()
    {
        return $this->hasMany(Localizacao::class, ['atribuicao_id' => 'id']);
    }

    /**
     * Gets query for [[Requisicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicao()
    {
        return $this->hasOne(Requisicao::class, ['id' => 'requisicao_id']);
    }

    /**
     * Gets query for [[Viatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViatura()
    {
        return $this->hasOne(Viatura::class, ['id' => 'viatura_id']);
    }

}
