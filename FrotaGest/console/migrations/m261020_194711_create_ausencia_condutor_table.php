<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ausencia_condutor}}`.
 */
class m261020_194711_create_ausencia_condutor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela ausencia_condutor
        $this->createTable('{{%ausencia_condutor}}', [
            'id' => $this->primaryKey(),
            //FK: condutor ausente
            'condutor_id' => $this->integer()->notNull(),
            'data_inicio' => $this->date()->notNull(),
            'data_fim' => $this->date()->notNull(),
            //ferias, baixa...
            'motivo' => $this->string(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: ausencia_condutor.condutor_id -> condutor.id
        $this->createIndex('idx-ausencia_condutor-condutor_id', '{{%ausencia_condutor}}', 'condutor_id');
        $this->addForeignKey(
            'fk-ausencia_condutor-condutor_id',
            '{{%ausencia_condutor}}',
            'condutor_id',
            '{{%condutor}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-ausencia_condutor-condutor_id', '{{%ausencia_condutor}}');
        $this->dropIndex('idx-ausencia_condutor-condutor_id', '{{%ausencia_condutor}}');
        $this->dropTable('{{%ausencia_condutor}}');
    }
}
