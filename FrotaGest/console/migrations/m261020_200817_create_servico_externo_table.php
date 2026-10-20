<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%servico_externo}}`.
 */
class m261020_200817_create_servico_externo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela servico_externo
        $this->createTable('{{%servico_externo}}', [
            'id' => $this->primaryKey(),
            //FK: quem alterou por ultimo (tabela user); vazio nos valores iniciais
            'atualizado_por' => $this->integer(),
            //Google Calendar ou Firebase Cloud Messaging
            'nome' => $this->string()->notNull(),
            'credenciais' => $this->string(),
            'ativo' => $this->boolean()->notNull()->defaultValue(0),
            'atualizado_em' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: servico_externo.atualizado_por -> user.id
        $this->createIndex('idx-servico_externo-atualizado_por', '{{%servico_externo}}', 'atualizado_por');
        $this->addForeignKey(
            'fk-servico_externo-atualizado_por',
            '{{%servico_externo}}',
            'atualizado_por',
            '{{%user}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-servico_externo-atualizado_por', '{{%servico_externo}}');
        $this->dropIndex('idx-servico_externo-atualizado_por', '{{%servico_externo}}');
        $this->dropTable('{{%servico_externo}}');
    }
}
