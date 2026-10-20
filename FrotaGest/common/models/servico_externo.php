<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "servico_externo".
 *
 * @property int $id
 * @property int|null $atualizado_por
 * @property string $nome
 * @property string|null $credenciais
 * @property int $ativo
 * @property string $atualizado_em
 *
 * @property User $atualizadoPor
 */
class servico_externo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'servico_externo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['atualizado_por', 'credenciais'], 'default', 'value' => null],
            [['ativo'], 'default', 'value' => 0],
            [['atualizado_por', 'ativo'], 'integer'],
            [['nome', 'atualizado_em'], 'required'],
            [['atualizado_em'], 'safe'],
            [['nome', 'credenciais'], 'string', 'max' => 255],
            [['atualizado_por'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['atualizado_por' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'atualizado_por' => 'Atualizado Por',
            'nome' => 'Nome',
            'credenciais' => 'Credenciais',
            'ativo' => 'Ativo',
            'atualizado_em' => 'Atualizado Em',
        ];
    }

    /**
     * Gets query for [[AtualizadoPor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtualizadoPor()
    {
        return $this->hasOne(User::class, ['id' => 'atualizado_por']);
    }

}
