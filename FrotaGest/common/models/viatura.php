<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "viatura".
 *
 * @property int $id
 * @property int $categoria_id
 * @property string $matricula
 * @property string $marca
 * @property string $modelo
 * @property string $combustivel
 * @property string|null $caracteristicas
 * @property string|null $foto
 * @property string|null $qr_code
 * @property string $estado
 * @property int $km_atual
 *
 * @property alerta[] $alertas
 * @property anexo[] $anexos
 * @property atribuicao[] $atribuicaos
 * @property categoria $categoria
 * @property manutencao[] $manutencaos
 * @property necessidade_manutencao[] $necessidadeManutencaos
 * @property orcamento_compra[] $orcamentoCompras
 */
class viatura extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viatura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caracteristicas', 'foto', 'qr_code'], 'default', 'value' => null],
            [['estado'], 'default', 'value' => 'disponivel'],
            [['km_atual'], 'default', 'value' => 0],
            [['categoria_id', 'matricula', 'marca', 'modelo', 'combustivel'], 'required'],
            [['categoria_id', 'km_atual'], 'integer'],
            [['caracteristicas'], 'string'],
            [['matricula', 'marca', 'modelo', 'combustivel', 'foto', 'qr_code', 'estado'], 'string', 'max' => 255],
            [['matricula'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => categoria::class, 'targetAttribute' => ['categoria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categoria_id' => 'Categoria ID',
            'matricula' => 'Matricula',
            'marca' => 'Marca',
            'modelo' => 'Modelo',
            'combustivel' => 'Combustivel',
            'caracteristicas' => 'Caracteristicas',
            'foto' => 'Foto',
            'qr_code' => 'Qr Code',
            'estado' => 'Estado',
            'km_atual' => 'Km Atual',
        ];
    }

    /**
     * Gets query for [[Alertas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(alerta::class, ['viatura_id' => 'id']);
    }

    /**
     * Gets query for [[Anexos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnexos()
    {
        return $this->hasMany(anexo::class, ['viatura_id' => 'id']);
    }

    /**
     * Gets query for [[Atribuicaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtribuicaos()
    {
        return $this->hasMany(atribuicao::class, ['viatura_id' => 'id']);
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
     * Gets query for [[Manutencaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManutencaos()
    {
        return $this->hasMany(manutencao::class, ['viatura_id' => 'id']);
    }

    /**
     * Gets query for [[NecessidadeManutencaos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNecessidadeManutencaos()
    {
        return $this->hasMany(necessidade_manutencao::class, ['viatura_id' => 'id']);
    }

    /**
     * Gets query for [[OrcamentoCompras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrcamentoCompras()
    {
        return $this->hasMany(orcamento_compra::class, ['viatura_id' => 'id']);
    }

}
