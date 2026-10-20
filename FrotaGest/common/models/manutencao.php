<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manutencao".
 *
 * @property int $id
 * @property int $viatura_id
 * @property int|null $tecnico_id
 * @property int|null $orcamento_id
 * @property string $data
 * @property string $tipo
 * @property int|null $km
 * @property float|null $horas_trabalho
 * @property string|null $descricao
 * @property string $estado
 *
 * @property OrcamentoCompra $orcamento
 * @property Peca[] $pecas
 * @property User $tecnico
 * @property Viatura $viatura
 */
class manutencao extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manutencao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tecnico_id', 'orcamento_id', 'km', 'horas_trabalho', 'descricao'], 'default', 'value' => null],
            [['viatura_id', 'data', 'tipo', 'estado'], 'required'],
            [['viatura_id', 'tecnico_id', 'orcamento_id', 'km'], 'integer'],
            [['data'], 'safe'],
            [['horas_trabalho'], 'number'],
            [['tipo', 'descricao', 'estado'], 'string', 'max' => 255],
            [['orcamento_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrcamentoCompra::class, 'targetAttribute' => ['orcamento_id' => 'id']],
            [['tecnico_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['tecnico_id' => 'id']],
            [['viatura_id'], 'exist', 'skipOnError' => true, 'targetClass' => Viatura::class, 'targetAttribute' => ['viatura_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'viatura_id' => 'Viatura ID',
            'tecnico_id' => 'Tecnico ID',
            'orcamento_id' => 'Orcamento ID',
            'data' => 'Data',
            'tipo' => 'Tipo',
            'km' => 'Km',
            'horas_trabalho' => 'Horas Trabalho',
            'descricao' => 'Descricao',
            'estado' => 'Estado',
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

    /**
     * Gets query for [[Pecas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPecas()
    {
        return $this->hasMany(Peca::class, ['manutencao_id' => 'id']);
    }

    /**
     * Gets query for [[Tecnico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTecnico()
    {
        return $this->hasOne(User::class, ['id' => 'tecnico_id']);
    }

    /**
     * Gets query for [[Viatura]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getViatura()
    {
        return $this->hasOne(Viatura::class, ['id' => 'viatura_id']);
    }

}
