<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "parametro".
 *
 * @property int $id
 * @property int|null $atualizado_por
 * @property string $chave
 * @property string $valor
 * @property string $atualizado_em
 *
 * @property User $atualizadoPor
 */
class parametro extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parametro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['atualizado_por'], 'default', 'value' => null],
            [['atualizado_por'], 'integer'],
            [['chave', 'valor', 'atualizado_em'], 'required'],
            [['atualizado_em'], 'safe'],
            [['chave', 'valor'], 'string', 'max' => 255],
            [['chave'], 'unique'],
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
            'chave' => 'Chave',
            'valor' => 'Valor',
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
