<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "condutor".
 *
 * @property int $id
 * @property string $nome
 * @property string $n_carta
 * @property string $validade_carta
 * @property string|null $telefone
 * @property int $ativo
 *
 * @property atribuicao[] $atribuicaos
 * @property ausencia_condutor[] $ausenciaCondutors
 */
class condutor extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'condutor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefone'], 'default', 'value' => null],
            [['ativo'], 'default', 'value' => 1],
            [['nome', 'n_carta', 'validade_carta'], 'required'],
            [['validade_carta'], 'safe'],
            [['ativo'], 'integer'],
            [['nome', 'n_carta', 'telefone'], 'string', 'max' => 255],
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
            'n_carta' => 'N Carta',
            'validade_carta' => 'Validade Carta',
            'telefone' => 'Telefone',
            'ativo' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Atribuicaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtribuicaos()
    {
        return $this->hasMany(atribuicao::class, ['condutor_id' => 'id']);
    }

    /**
     * Gets query for [[AusenciaCondutors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAusenciaCondutors()
    {
        return $this->hasMany(ausencia_condutor::class, ['condutor_id' => 'id']);
    }

}
