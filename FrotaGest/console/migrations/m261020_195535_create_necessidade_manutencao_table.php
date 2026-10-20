<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%necessidade_manutencao}}`.
 */
class m261020_195535_create_necessidade_manutencao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela necessidade_manutencao
        $this->createTable('{{%necessidade_manutencao}}', [
            'id' => $this->primaryKey(),
            //FK: viatura
            'viatura_id' => $this->integer()->notNull(),
            //FK: so preenchido quando e agrupada num orcamento
            'orcamento_id' => $this->integer(),
            //FK: coordenador ou tecnico (tabela user)
            'registada_por' => $this->integer()->notNull(),
            //revisao, inspecao, pneus ou peca
            'tipo' => $this->string()->notNull(),
            'descricao' => $this->string(),
            'data' => $this->date()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: necessidade_manutencao.viatura_id -> viatura.id
        $this->createIndex('idx-necessidade_manutencao-viatura_id', '{{%necessidade_manutencao}}', 'viatura_id');
        $this->addForeignKey(
            'fk-necessidade_manutencao-viatura_id',
            '{{%necessidade_manutencao}}',
            'viatura_id',
            '{{%viatura}}',
            'id'
        );

        //indice e chave estrangeira: necessidade_manutencao.orcamento_id -> orcamento_compra.id
        $this->createIndex('idx-necessidade_manutencao-orcamento_id', '{{%necessidade_manutencao}}', 'orcamento_id');
        $this->addForeignKey(
            'fk-necessidade_manutencao-orcamento_id',
            '{{%necessidade_manutencao}}',
            'orcamento_id',
            '{{%orcamento_compra}}',
            'id'
        );

        //indice e chave estrangeira: necessidade_manutencao.registada_por -> user.id
        $this->createIndex('idx-necessidade_manutencao-registada_por', '{{%necessidade_manutencao}}', 'registada_por');
        $this->addForeignKey(
            'fk-necessidade_manutencao-registada_por',
            '{{%necessidade_manutencao}}',
            'registada_por',
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-necessidade_manutencao-registada_por', '{{%necessidade_manutencao}}');
        $this->dropIndex('idx-necessidade_manutencao-registada_por', '{{%necessidade_manutencao}}');
        $this->dropForeignKey('fk-necessidade_manutencao-orcamento_id', '{{%necessidade_manutencao}}');
        $this->dropIndex('idx-necessidade_manutencao-orcamento_id', '{{%necessidade_manutencao}}');
        $this->dropForeignKey('fk-necessidade_manutencao-viatura_id', '{{%necessidade_manutencao}}');
        $this->dropIndex('idx-necessidade_manutencao-viatura_id', '{{%necessidade_manutencao}}');
        $this->dropTable('{{%necessidade_manutencao}}');
    }
}
