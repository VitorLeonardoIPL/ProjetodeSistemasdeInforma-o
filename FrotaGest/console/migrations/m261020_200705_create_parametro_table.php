<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parametro}}`.
 */
class m261020_200705_create_parametro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela parametro
        $this->createTable('{{%parametro}}', [
            'id' => $this->primaryKey(),
            //FK: quem alterou por ultimo (tabela user); vazio nos valores iniciais
            'atualizado_por' => $this->integer(),
            //nome do parametro
            'chave' => $this->string()->notNull()->unique(),
            'valor' => $this->string()->notNull(),
            'atualizado_em' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: parametro.atualizado_por -> user.id
        $this->createIndex('idx-parametro-atualizado_por', '{{%parametro}}', 'atualizado_por');
        $this->addForeignKey(
            'fk-parametro-atualizado_por',
            '{{%parametro}}',
            'atualizado_por',
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-parametro-atualizado_por', '{{%parametro}}');
        $this->dropIndex('idx-parametro-atualizado_por', '{{%parametro}}');
        $this->dropTable('{{%parametro}}');
    }
}
