<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notificacao}}`.
 */
class m261020_195150_create_notificacao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela notificacao
        $this->createTable('{{%notificacao}}', [
            'id' => $this->primaryKey(),
            //FK: destinatario (tabela user)
            'utilizador_id' => $this->integer()->notNull(),
            //FK: preenchido se vem de uma requisicao
            'requisicao_id' => $this->integer(),
            //FK: preenchido se vem de um alerta
            'alerta_id' => $this->integer(),
            'tipo' => $this->string()->notNull(),
            'titulo' => $this->string()->notNull(),
            'mensagem' => $this->string(),
            //0 por ler, 1 lida
            'lida' => $this->boolean()->notNull()->defaultValue(0),
            'data_envio' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: notificacao.utilizador_id -> user.id
        $this->createIndex('idx-notificacao-utilizador_id', '{{%notificacao}}', 'utilizador_id');
        $this->addForeignKey(
            'fk-notificacao-utilizador_id',
            '{{%notificacao}}',
            'utilizador_id',
            '{{%user}}',
            'id'
        );

        //indice e chave estrangeira: notificacao.requisicao_id -> requisicao.id
        $this->createIndex('idx-notificacao-requisicao_id', '{{%notificacao}}', 'requisicao_id');
        $this->addForeignKey(
            'fk-notificacao-requisicao_id',
            '{{%notificacao}}',
            'requisicao_id',
            '{{%requisicao}}',
            'id'
        );

        //indice e chave estrangeira: notificacao.alerta_id -> alerta.id
        $this->createIndex('idx-notificacao-alerta_id', '{{%notificacao}}', 'alerta_id');
        $this->addForeignKey(
            'fk-notificacao-alerta_id',
            '{{%notificacao}}',
            'alerta_id',
            '{{%alerta}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-notificacao-alerta_id', '{{%notificacao}}');
        $this->dropIndex('idx-notificacao-alerta_id', '{{%notificacao}}');
        $this->dropForeignKey('fk-notificacao-requisicao_id', '{{%notificacao}}');
        $this->dropIndex('idx-notificacao-requisicao_id', '{{%notificacao}}');
        $this->dropForeignKey('fk-notificacao-utilizador_id', '{{%notificacao}}');
        $this->dropIndex('idx-notificacao-utilizador_id', '{{%notificacao}}');
        $this->dropTable('{{%notificacao}}');
    }
}
