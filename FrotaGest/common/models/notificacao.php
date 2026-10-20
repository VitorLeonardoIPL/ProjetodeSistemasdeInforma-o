<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "notificacao".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int|null $requisicao_id
 * @property int|null $alerta_id
 * @property string $tipo
 * @property string $titulo
 * @property string|null $mensagem
 * @property int $lida
 * @property string $data_envio
 *
 * @property Alerta $alerta
 * @property Requisicao $requisicao
 * @property User $utilizador
 */
class notificacao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notificacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['requisicao_id', 'alerta_id', 'mensagem'], 'default', 'value' => null],
            [['lida'], 'default', 'value' => 0],
            [['utilizador_id', 'tipo', 'titulo', 'data_envio'], 'required'],
            [['utilizador_id', 'requisicao_id', 'alerta_id', 'lida'], 'integer'],
            [['data_envio'], 'safe'],
            [['tipo', 'titulo', 'mensagem'], 'string', 'max' => 255],
            [['alerta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alerta::class, 'targetAttribute' => ['alerta_id' => 'id']],
            [['requisicao_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requisicao::class, 'targetAttribute' => ['requisicao_id' => 'id']],
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
            'requisicao_id' => 'Requisicao ID',
            'alerta_id' => 'Alerta ID',
            'tipo' => 'Tipo',
            'titulo' => 'Titulo',
            'mensagem' => 'Mensagem',
            'lida' => 'Lida',
            'data_envio' => 'Data Envio',
        ];
    }

    /**
     * Gets query for [[Alerta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerta()
    {
        return $this->hasOne(Alerta::class, ['id' => 'alerta_id']);
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
     * Gets query for [[Utilizador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUtilizador()
    {
        return $this->hasOne(User::class, ['id' => 'utilizador_id']);
    }

}
