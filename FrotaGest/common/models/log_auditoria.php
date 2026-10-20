<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_auditoria".
 *
 * @property int $id
 * @property int|null $utilizador_id
 * @property string $canal
 * @property string $nivel
 * @property string $acao
 * @property string|null $tabela_afetada
 * @property int|null $registo_id
 * @property string|null $detalhe
 * @property string $data_hora
 *
 * @property User $utilizador
 */
class log_auditoria extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log_auditoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['utilizador_id', 'tabela_afetada', 'registo_id', 'detalhe'], 'default', 'value' => null],
            [['utilizador_id', 'registo_id'], 'integer'],
            [['canal', 'nivel', 'acao', 'data_hora'], 'required'],
            [['data_hora'], 'safe'],
            [['canal', 'nivel', 'acao', 'tabela_afetada', 'detalhe'], 'string', 'max' => 255],
            [['utilizador_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['utilizador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'utilizador_id' => 'Utilizador ID',
            'canal' => 'Canal',
            'nivel' => 'Nivel',
            'acao' => 'Acao',
            'tabela_afetada' => 'Tabela Afetada',
            'registo_id' => 'Registo ID',
            'detalhe' => 'Detalhe',
            'data_hora' => 'Data Hora',
        ];
    }

    /**
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }

}
