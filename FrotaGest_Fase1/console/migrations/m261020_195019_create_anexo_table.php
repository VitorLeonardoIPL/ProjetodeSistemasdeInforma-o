<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%anexo}}`.
 */
class m261020_195019_create_anexo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela anexo
        $this->createTable('{{%anexo}}', [
            'id' => $this->primaryKey(),
            //FK: viatura a que o ficheiro pertence
            'viatura_id' => $this->integer()->notNull(),
            //FK: so preenchido nas fotografias das checklists
            'checklist_id' => $this->integer(),
            //foto ou documento
            'categoria' => $this->string()->notNull(),
            //frente, tras, esquerda, direita / seguro, inspecao, iuc
            'tipo' => $this->string()->notNull(),
            //caminho do ficheiro
            'ficheiro' => $this->string()->notNull(),
            //so preenchida nos documentos legais
            'data_validade' => $this->date(),
            //1 se o coordenador assinalou um possivel dano
            'risco' => $this->boolean()->notNull()->defaultValue(0),
            'data_registo' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: anexo.viatura_id -> viatura.id
        $this->createIndex('idx-anexo-viatura_id', '{{%anexo}}', 'viatura_id');
        $this->addForeignKey(
            'fk-anexo-viatura_id',
            '{{%anexo}}',
            'viatura_id',
            '{{%viatura}}',
            'id'
        );

        //indice e chave estrangeira: anexo.checklist_id -> checklist.id
        $this->createIndex('idx-anexo-checklist_id', '{{%anexo}}', 'checklist_id');
        $this->addForeignKey(
            'fk-anexo-checklist_id',
            '{{%anexo}}',
            'checklist_id',
            '{{%checklist}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-anexo-checklist_id', '{{%anexo}}');
        $this->dropIndex('idx-anexo-checklist_id', '{{%anexo}}');
        $this->dropForeignKey('fk-anexo-viatura_id', '{{%anexo}}');
        $this->dropIndex('idx-anexo-viatura_id', '{{%anexo}}');
        $this->dropTable('{{%anexo}}');
    }
}
