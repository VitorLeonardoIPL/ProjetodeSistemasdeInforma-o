<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "peca".
 *
 * @property int $id
 * @property int $manutencao_id
 * @property string $descricao
 * @property int $quantidade
 * @property float $custo
 * @property string|null $fotografia
 *
 * @property manutencao $manutencao
 */
class peca extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'peca';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fotografia'], 'default', 'value' => null],
            [['quantidade'], 'default', 'value' => 1],
            [['manutencao_id', 'descricao', 'custo'], 'required'],
            [['manutencao_id', 'quantidade'], 'integer'],
            [['custo'], 'number'],
            [['descricao', 'fotografia'], 'string', 'max' => 255],
            [['manutencao_id'], 'exist', 'skipOnError' => true, 'targetClass' => manutencao::class, 'targetAttribute' => ['manutencao_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manutencao_id' => 'Manutencao ID',
            'descricao' => 'Descricao',
            'quantidade' => 'Quantidade',
            'custo' => 'Custo',
            'fotografia' => 'Fotografia',
        ];
    }

    /**
     * Gets query for [[Manutencao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManutencao()
    {
        return $this->hasOne(manutencao::class, ['id' => 'manutencao_id']);
    }

}
