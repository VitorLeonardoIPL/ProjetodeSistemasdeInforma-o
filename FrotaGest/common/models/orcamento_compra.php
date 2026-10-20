<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orcamento_compra".
 *
 * @property int $id
 * @property int $viatura_id
 * @property int $criado_por
 * @property string $fornecedor
 * @property string $estado
 * @property string $data
 *
 * @property User $criadoPor
 * @property ItemOrcamento[] $itemOrcamentos
 * @property Manutencao[] $manutencaos
 * @property NecessidadeManutencao[] $necessidadeManutencaos
 * @property Viatura $viatura
 */
class orcamento_compra extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orcamento_compra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estado'], 'default', 'value' => 'rascunho'],
            [['viatura_id', 'criado_por', 'fornecedor', 'data'], 'required'],
            [['viatura_id', 'criado_por'], 'integer'],
            [['data'], 'safe'],
            [['fornecedor', 'estado'], 'string', 'max' => 255],
            [['criado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['criado_por' => 'id']],
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
            'viatura_id' => 'Viatura ID',
            'criado_por' => 'Criado Por',
            'fornecedor' => 'Fornecedor',
            'estado' => 'Estado',
            'data' => 'Data',
        ];
    }

    /**
     * Gets query for [[CriadoPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCriadoPor()
    {
        return $this->hasOne(User::class, ['id' => 'criado_por']);
    }

    /**
     * Gets query for [[ItemOrcamentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItemOrcamentos()
    {
        return $this->hasMany(ItemOrcamento::class, ['orcamento_id' => 'id']);
    }

    /**
     * Gets query for [[Manutencaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManutencaos()
    {
        return $this->hasMany(Manutencao::class, ['orcamento_id' => 'id']);
    }

    /**
     * Gets query for [[NecessidadeManutencaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNecessidadeManutencaos()
    {
        return $this->hasMany(NecessidadeManutencao::class, ['orcamento_id' => 'id']);
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
