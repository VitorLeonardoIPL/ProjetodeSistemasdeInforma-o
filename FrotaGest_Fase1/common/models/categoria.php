<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id
 * @property string $nome
 * @property string|null $descricao
 *
 * @property requisicao[] $requisicaos
 * @property viatura[] $viaturas
 */
class categoria extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'default', 'value' => null],
            [['nome'], 'required'],
            [['nome', 'descricao'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'descricao' => 'Descricao',
        ];
    }

    /**
     * Gets query for [[Requisicaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequisicaos()
    {
        return $this->hasMany(requisicao::class, ['categoria_id' => 'id']);
    }

    /**
     * Gets query for [[Viaturas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViaturas()
    {
        return $this->hasMany(viatura::class, ['categoria_id' => 'id']);
    }

}
