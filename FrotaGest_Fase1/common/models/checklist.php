<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "checklist".
 *
 * @property int $id
 * @property int $atribuicao_id
 * @property string $tipo
 * @property int $km
 * @property string $data_hora
 * @property string $estado_geral
 * @property int $docs_a_bordo
 * @property string|null $observacoes
 *
 * @property anexo[] $anexos
 * @property atribuicao $atribuicao
 */
class checklist extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'checklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['observacoes'], 'default', 'value' => null],
            [['docs_a_bordo'], 'default', 'value' => 0],
            [['atribuicao_id', 'tipo', 'km', 'data_hora', 'estado_geral'], 'required'],
            [['atribuicao_id', 'km', 'docs_a_bordo'], 'integer'],
            [['data_hora'], 'safe'],
            [['tipo', 'estado_geral', 'observacoes'], 'string', 'max' => 255],
            [['atribuicao_id'], 'exist', 'skipOnError' => true, 'targetClass' => atribuicao::class, 'targetAttribute' => ['atribuicao_id' => 'id']],
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
            'tipo' => 'Tipo',
            'km' => 'Km',
            'data_hora' => 'Data Hora',
            'estado_geral' => 'Estado Geral',
            'docs_a_bordo' => 'Docs A Bordo',
            'observacoes' => 'Observacoes',
        ];
    }

    /**
     * Gets query for [[Anexos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnexos()
    {
        return $this->hasMany(anexo::class, ['checklist_id' => 'id']);
    }

    /**
     * Gets query for [[Atribuicao]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtribuicao()
    {
        return $this->hasOne(atribuicao::class, ['id' => 'atribuicao_id']);
    }

}
