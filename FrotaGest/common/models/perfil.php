<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "perfil".
 *
 * @property int $id
 * @property int $user_id
 * @property string $nome
 * @property string|null $telemovel
 * @property string|null $departamento
 * @property string|null $n_carta
 * @property string|null $validade_carta
 * @property string|null $token_push
 * @property string|null $role
 *
 * @property User $user
 */
class perfil extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perfil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telemovel', 'departamento', 'n_carta', 'validade_carta', 'token_push', 'role'], 'default', 'value' => null],
            [['user_id', 'nome'], 'required'],
            [['user_id'], 'integer'],
            [['validade_carta'], 'safe'],
            [['role'], 'string', 'max' => 64],
            [['nome', 'telemovel', 'departamento', 'n_carta', 'token_push'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nome' => 'Nome',
            'telemovel' => 'Telemovel',
            'departamento' => 'Departamento',
            'n_carta' => 'N Carta',
            'validade_carta' => 'Validade Carta',
            'token_push' => 'Token Push',
            'role' => 'Role',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
