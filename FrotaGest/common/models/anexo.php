<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "anexo".
 *
 * @property int $id
 * @property int $viatura_id
 * @property int|null $checklist_id
 * @property string $categoria
 * @property string $tipo
 * @property string $ficheiro
 * @property string|null $data_validade
 * @property int $risco
 * @property string $data_registo
 *
 * @property Checklist $checklist
 * @property Viatura $viatura
 */
class anexo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anexo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['checklist_id', 'data_validade'], 'default', 'value' => null],
            [['risco'], 'default', 'value' => 0],
            [['viatura_id', 'categoria', 'tipo', 'ficheiro', 'data_registo'], 'required'],
            [['viatura_id', 'checklist_id', 'risco'], 'integer'],
            [['data_validade', 'data_registo'], 'safe'],
            [['categoria', 'tipo', 'ficheiro'], 'string', 'max' => 255],
            [['checklist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Checklist::class, 'targetAttribute' => ['checklist_id' => 'id']],
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
            'checklist_id' => 'Checklist ID',
            'categoria' => 'Categoria',
            'tipo' => 'Tipo',
            'ficheiro' => 'Ficheiro',
            'data_validade' => 'Data Validade',
            'risco' => 'Risco',
            'data_registo' => 'Data Registo',
        ];
    }

    /**
     * Gets query for [[Checklist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChecklist()
    {
        return $this->hasOne(Checklist::class, ['id' => 'checklist_id']);
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
