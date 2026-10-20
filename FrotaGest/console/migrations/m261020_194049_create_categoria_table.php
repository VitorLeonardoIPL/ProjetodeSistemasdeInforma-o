<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categoria}}`.
 */
class m261020_194049_create_categoria_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela categoria
        $this->createTable('{{%categoria}}', [
            'id' => $this->primaryKey(),
            //nome da categoria (ex.: ligeiro)
            'nome' => $this->string()->notNull(),
            //descricao, pode ficar vazia
            'descricao' => $this->string(),
        ], 'ENGINE=InnoDB');
    }

    public function safeDown()
    {
        //desfazer o safeUp: apagar a tabela
        $this->dropTable('{{%categoria}}');
    }
}
