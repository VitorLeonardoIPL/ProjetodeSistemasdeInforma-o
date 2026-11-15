<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orcamento_compra}}`.
 */
class m261020_195320_create_orcamento_compra_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela orcamento_compra
        $this->createTable('{{%orcamento_compra}}', [
            'id' => $this->primaryKey(),
            //FK: viatura
            'viatura_id' => $this->integer()->notNull(),
            //FK: coordenador que o montou (tabela user)
            'criado_por' => $this->integer()->notNull(),
            //fornecedor externo
            'fornecedor' => $this->string()->notNull(),
            //rascunho, pendente, aceite ou recusado
            'estado' => $this->string()->notNull()->defaultValue('rascunho'),
            'data' => $this->date()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: orcamento_compra.viatura_id -> viatura.id
        $this->createIndex('idx-orcamento_compra-viatura_id', '{{%orcamento_compra}}', 'viatura_id');
        $this->addForeignKey(
            'fk-orcamento_compra-viatura_id',
            '{{%orcamento_compra}}',
            'viatura_id',
            '{{%viatura}}',
            'id'
        );

        //indice e chave estrangeira: orcamento_compra.criado_por -> user.id
        $this->createIndex('idx-orcamento_compra-criado_por', '{{%orcamento_compra}}', 'criado_por');
        $this->addForeignKey(
            'fk-orcamento_compra-criado_por',
            '{{%orcamento_compra}}',
            'criado_por',
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-orcamento_compra-criado_por', '{{%orcamento_compra}}');
        $this->dropIndex('idx-orcamento_compra-criado_por', '{{%orcamento_compra}}');
        $this->dropForeignKey('fk-orcamento_compra-viatura_id', '{{%orcamento_compra}}');
        $this->dropIndex('idx-orcamento_compra-viatura_id', '{{%orcamento_compra}}');
        $this->dropTable('{{%orcamento_compra}}');
    }
}
