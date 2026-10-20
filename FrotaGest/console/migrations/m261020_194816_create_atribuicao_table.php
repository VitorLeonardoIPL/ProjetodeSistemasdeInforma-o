<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%atribuicao}}`.
 */
class m261020_194816_create_atribuicao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela atribuicao
        $this->createTable('{{%atribuicao}}', [
            'id' => $this->primaryKey(),
            //FK: pedido aprovado
            'requisicao_id' => $this->integer()->notNull(),
            //FK: viatura atribuida
            'viatura_id' => $this->integer()->notNull(),
            //FK: condutor atribuido
            'condutor_id' => $this->integer()->notNull(),
            //FK: coordenador que aprovou (tabela user)
            'aprovada_por' => $this->integer()->notNull(),
            'data_atribuicao' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: atribuicao.requisicao_id -> requisicao.id
        $this->createIndex('idx-atribuicao-requisicao_id', '{{%atribuicao}}', 'requisicao_id');
        $this->addForeignKey(
            'fk-atribuicao-requisicao_id',
            '{{%atribuicao}}',
            'requisicao_id',
            '{{%requisicao}}',
            'id'
        );

        //indice e chave estrangeira: atribuicao.viatura_id -> viatura.id
        $this->createIndex('idx-atribuicao-viatura_id', '{{%atribuicao}}', 'viatura_id');
        $this->addForeignKey(
            'fk-atribuicao-viatura_id',
            '{{%atribuicao}}',
            'viatura_id',
            '{{%viatura}}',
            'id'
        );

        //indice e chave estrangeira: atribuicao.condutor_id -> condutor.id
        $this->createIndex('idx-atribuicao-condutor_id', '{{%atribuicao}}', 'condutor_id');
        $this->addForeignKey(
            'fk-atribuicao-condutor_id',
            '{{%atribuicao}}',
            'condutor_id',
            '{{%condutor}}',
            'id'
        );

        //indice e chave estrangeira: atribuicao.aprovada_por -> user.id
        $this->createIndex('idx-atribuicao-aprovada_por', '{{%atribuicao}}', 'aprovada_por');
        $this->addForeignKey(
            'fk-atribuicao-aprovada_por',
            '{{%atribuicao}}',
            'aprovada_por',
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-atribuicao-aprovada_por', '{{%atribuicao}}');
        $this->dropIndex('idx-atribuicao-aprovada_por', '{{%atribuicao}}');
        $this->dropForeignKey('fk-atribuicao-condutor_id', '{{%atribuicao}}');
        $this->dropIndex('idx-atribuicao-condutor_id', '{{%atribuicao}}');
        $this->dropForeignKey('fk-atribuicao-viatura_id', '{{%atribuicao}}');
        $this->dropIndex('idx-atribuicao-viatura_id', '{{%atribuicao}}');
        $this->dropForeignKey('fk-atribuicao-requisicao_id', '{{%atribuicao}}');
        $this->dropIndex('idx-atribuicao-requisicao_id', '{{%atribuicao}}');
        $this->dropTable('{{%atribuicao}}');
    }
}
