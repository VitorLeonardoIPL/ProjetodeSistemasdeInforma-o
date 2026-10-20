<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%peca}}`.
 */
class m261020_200111_create_peca_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela peca
        $this->createTable('{{%peca}}', [
            'id' => $this->primaryKey(),
            //FK: manutencao em que foi usada
            'manutencao_id' => $this->integer()->notNull(),
            'descricao' => $this->string()->notNull(),
            'quantidade' => $this->integer()->notNull()->defaultValue(1),
            'custo' => $this->float()->notNull(),
            'fotografia' => $this->string(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: peca.manutencao_id -> manutencao.id
        $this->createIndex('idx-peca-manutencao_id', '{{%peca}}', 'manutencao_id');
        $this->addForeignKey(
            'fk-peca-manutencao_id',
            '{{%peca}}',
            'manutencao_id',
            '{{%manutencao}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-peca-manutencao_id', '{{%peca}}');
        $this->dropIndex('idx-peca-manutencao_id', '{{%peca}}');
        $this->dropTable('{{%peca}}');
    }
}
