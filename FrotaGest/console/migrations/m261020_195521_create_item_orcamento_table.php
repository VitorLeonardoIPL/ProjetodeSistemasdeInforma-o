<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%item_orcamento}}`.
 */
class m261020_195521_create_item_orcamento_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela item_orcamento
        $this->createTable('{{%item_orcamento}}', [
            'id' => $this->primaryKey(),
            //FK: orcamento a que o item pertence
            'orcamento_id' => $this->integer()->notNull(),
            //peca, servico ou seguro
            'tipo' => $this->string()->notNull(),
            'descricao' => $this->string()->notNull(),
            'quantidade' => $this->integer()->notNull()->defaultValue(1),
            'preco_unitario' => $this->float()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: item_orcamento.orcamento_id -> orcamento_compra.id
        $this->createIndex('idx-item_orcamento-orcamento_id', '{{%item_orcamento}}', 'orcamento_id');
        $this->addForeignKey(
            'fk-item_orcamento-orcamento_id',
            '{{%item_orcamento}}',
            'orcamento_id',
            '{{%orcamento_compra}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-item_orcamento-orcamento_id', '{{%item_orcamento}}');
        $this->dropIndex('idx-item_orcamento-orcamento_id', '{{%item_orcamento}}');
        $this->dropTable('{{%item_orcamento}}');
    }
}
