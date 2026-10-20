<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fatura_combustivel".
 *
 * @property int $id
 * @property int $atribuicao_id
 * @property string $fotografia
 * @property float|null $litros
 * @property float|null $valor
 * @property string $data_registo
 *
 * @property Atribuicao $atribuicao
 */
class fatura_combustivel extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fatura_combustivel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['litros', 'valor'], 'default', 'value' => null],
            [['atribuicao_id', 'fotografia', 'data_registo'], 'required'],
            [['atribuicao_id'], 'integer'],
            [['litros', 'valor'], 'number'],
            [['data_registo'], 'safe'],
            [['fotografia'], 'string', 'max' => 255],
            [['atribuicao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Atribuicao::class, 'targetAttribute' => ['atribuicao_id' => 'id']],
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
            'fotografia' => 'Fotografia',
            'litros' => 'Litros',
            'valor' => 'Valor',
            'data_registo' => 'Data Registo',
        ];
    }

    /**
     * Gets query for [[Atribuicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtribuicao()
    {
        return $this->hasOne(Atribuicao::class, ['id' => 'atribuicao_id']);
    }

}
