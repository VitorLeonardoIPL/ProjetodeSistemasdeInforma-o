<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manutencao}}`.
 */
class m261020_200055_create_manutencao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela manutencao
        $this->createTable('{{%manutencao}}', [
            'id' => $this->primaryKey(),
            //FK: viatura intervencionada
            'viatura_id' => $this->integer()->notNull(),
            //FK: tecnico responsavel (tabela user); vazio ate um tecnico assumir uma manutencao gerada por um orcamento
            'tecnico_id' => $this->integer(),
            //FK: so preenchido se nasceu de um orcamento aceite
            'orcamento_id' => $this->integer(),
            'data' => $this->date()->notNull(),
            'tipo' => $this->string()->notNull(),
            //quilometros na intervencao
            'km' => $this->integer(),
            'horas_trabalho' => $this->float(),
            'descricao' => $this->string(),
            //ao concluir, a viatura volta a ficar disponivel
            'estado' => $this->string()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: manutencao.viatura_id -> viatura.id
        $this->createIndex('idx-manutencao-viatura_id', '{{%manutencao}}', 'viatura_id');
        $this->addForeignKey(
            'fk-manutencao-viatura_id',
            '{{%manutencao}}',
            'viatura_id',
            '{{%viatura}}',
            'id'
        );

        //indice e chave estrangeira: manutencao.tecnico_id -> user.id
        $this->createIndex('idx-manutencao-tecnico_id', '{{%manutencao}}', 'tecnico_id');
        $this->addForeignKey(
            'fk-manutencao-tecnico_id',
            '{{%manutencao}}',
            'tecnico_id',
            '{{%user}}',
            'id'
        );

        //indice e chave estrangeira: manutencao.orcamento_id -> orcamento_compra.id
        $this->createIndex('idx-manutencao-orcamento_id', '{{%manutencao}}', 'orcamento_id');
        $this->addForeignKey(
            'fk-manutencao-orcamento_id',
            '{{%manutencao}}',
            'orcamento_id',
            '{{%orcamento_compra}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-manutencao-orcamento_id', '{{%manutencao}}');
        $this->dropIndex('idx-manutencao-orcamento_id', '{{%manutencao}}');
        $this->dropForeignKey('fk-manutencao-tecnico_id', '{{%manutencao}}');
        $this->dropIndex('idx-manutencao-tecnico_id', '{{%manutencao}}');
        $this->dropForeignKey('fk-manutencao-viatura_id', '{{%manutencao}}');
        $this->dropIndex('idx-manutencao-viatura_id', '{{%manutencao}}');
        $this->dropTable('{{%manutencao}}');
    }
}
