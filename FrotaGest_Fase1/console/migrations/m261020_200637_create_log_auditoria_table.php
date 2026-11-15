<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log_auditoria}}`.
 */
class m261020_200637_create_log_auditoria_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela log_auditoria
        $this->createTable('{{%log_auditoria}}', [
            'id' => $this->primaryKey(),
            //FK: quem fez a acao (vazio se nao havia login)
            'utilizador_id' => $this->integer(),
            //frontoffice, backoffice ou app
            'canal' => $this->string()->notNull(),
            //auditoria ou erro
            'nivel' => $this->string()->notNull(),
            'acao' => $this->string()->notNull(),
            'tabela_afetada' => $this->string(),
            'registo_id' => $this->integer(),
            'detalhe' => $this->string(),
            'data_hora' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: log_auditoria.utilizador_id -> user.id
        $this->createIndex('idx-log_auditoria-utilizador_id', '{{%log_auditoria}}', 'utilizador_id');
        $this->addForeignKey(
            'fk-log_auditoria-utilizador_id',
            '{{%log_auditoria}}',
            'utilizador_id',
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-log_auditoria-utilizador_id', '{{%log_auditoria}}');
        $this->dropIndex('idx-log_auditoria-utilizador_id', '{{%log_auditoria}}');
        $this->dropTable('{{%log_auditoria}}');
    }
}
