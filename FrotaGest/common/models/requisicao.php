<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "requisicao".
 *
 * @property int $id
 * @property int $utilizador_id
 * @property int $categoria_id
 * @property string $data_inicio
 * @property string $data_fim
 * @property string|null $destino
 * @property string $motivo
 * @property string $estado
 * @property string|null $motivo_recusa
 * @property string $data_pedido
 *
 * @property atribuicao[] $atribuicaos
 * @property categoria $categoria
 * @property notificacao[] $notificacaos
 * @property User $utilizador
 */
class requisicao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisicao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destino', 'motivo_recusa'], 'default', 'value' => null],
            [['estado'], 'default', 'value' => 'pendente'],
            [['utilizador_id', 'categoria_id', 'data_inicio', 'data_fim', 'motivo', 'data_pedido'], 'required'],
            [['utilizador_id', 'categoria_id'], 'integer'],
            [['data_inicio', 'data_fim', 'data_pedido'], 'safe'],
            [['destino', 'motivo', 'estado', 'motivo_recusa'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
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
            'categoria_id' => 'Categoria ID',
            'data_inicio' => 'Data Inicio',
            'data_fim' => 'Data Fim',
            'destino' => 'Destino',
            'motivo' => 'Motivo',
            'estado' => 'Estado',
            'motivo_recusa' => 'Motivo Recusa',
            'data_pedido' => 'Data Pedido',
        ];
    }

    /**
     * Gets query for [[Atribuicaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtribuicaos()
    {
        return $this->hasMany(atribuicao::class, ['requisicao_id' => 'id']);
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(categoria::class, ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Notificacaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotificacaos()
    {
        return $this->hasMany(notificacao::class, ['requisicao_id' => 'id']);
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
