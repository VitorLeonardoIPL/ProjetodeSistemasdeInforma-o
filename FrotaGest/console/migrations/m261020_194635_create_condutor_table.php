<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%condutor}}`.
 */
class m261020_194635_create_condutor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela condutor
        $this->createTable('{{%condutor}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            //numero da carta de conducao
            'n_carta' => $this->string()->notNull(),
            //validade da carta (nao se atribui com a carta expirada)
            'validade_carta' => $this->date()->notNull(),
            'telefone' => $this->string(),
            //1 ativo, 0 inativo (os inativos nao se atribuem)
            'ativo' => $this->boolean()->notNull()->defaultValue(1),
        ], 'ENGINE=InnoDB');
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropTable('{{%condutor}}');
    }
}
