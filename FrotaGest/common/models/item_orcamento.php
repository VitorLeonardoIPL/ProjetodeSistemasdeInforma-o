<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_orcamento".
 *
 * @property int $id
 * @property int $orcamento_id
 * @property string $tipo
 * @property string $descricao
 * @property int $quantidade
 * @property float $preco_unitario
 *
 * @property OrcamentoCompra $orcamento
 */
class item_orcamento extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_orcamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantidade'], 'default', 'value' => 1],
            [['orcamento_id', 'tipo', 'descricao', 'preco_unitario'], 'required'],
            [['orcamento_id', 'quantidade'], 'integer'],
            [['preco_unitario'], 'number'],
            [['tipo', 'descricao'], 'string', 'max' => 255],
            [['orcamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrcamentoCompra::class, 'targetAttribute' => ['orcamento_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orcamento_id' => 'Orcamento ID',
            'tipo' => 'Tipo',
            'descricao' => 'Descricao',
            'quantidade' => 'Quantidade',
            'preco_unitario' => 'Preco Unitario',
        ];
    }

    /**
     * Gets query for [[Orcamento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamento()
    {
        return $this->hasOne(OrcamentoCompra::class, ['id' => 'orcamento_id']);
    }

}
