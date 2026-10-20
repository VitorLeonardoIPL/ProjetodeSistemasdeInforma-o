<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%requisicao}}`.
 */
class m261020_194759_create_requisicao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela requisicao
        $this->createTable('{{%requisicao}}', [
            'id' => $this->primaryKey(),
            //FK: colaborador que fez o pedido (tabela user)
            'utilizador_id' => $this->integer()->notNull(),
            //FK: categoria de viatura pretendida
            'categoria_id' => $this->integer()->notNull(),
            'data_inicio' => $this->date()->notNull(),
            'data_fim' => $this->date()->notNull(),
            //opcional
            'destino' => $this->string(),
            'motivo' => $this->string()->notNull(),
            //pendente, aprovada, recusada, em curso, concluida, cancelada
            'estado' => $this->string()->notNull()->defaultValue('pendente'),
            //so preenchido nos pedidos recusados
            'motivo_recusa' => $this->string(),
            //quando o pedido foi feito
            'data_pedido' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: requisicao.utilizador_id -> user.id
        $this->createIndex('idx-requisicao-utilizador_id', '{{%requisicao}}', 'utilizador_id');
        $this->addForeignKey(
            'fk-requisicao-utilizador_id',
            '{{%requisicao}}',
            'utilizador_id',
            '{{%user}}',
            'id'
        );

        //indice e chave estrangeira: requisicao.categoria_id -> categoria.id
        $this->createIndex('idx-requisicao-categoria_id', '{{%requisicao}}', 'categoria_id');
        $this->addForeignKey(
            'fk-requisicao-categoria_id',
            '{{%requisicao}}',
            'categoria_id',
            '{{%categoria}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-requisicao-categoria_id', '{{%requisicao}}');
        $this->dropIndex('idx-requisicao-categoria_id', '{{%requisicao}}');
        $this->dropForeignKey('fk-requisicao-utilizador_id', '{{%requisicao}}');
        $this->dropIndex('idx-requisicao-utilizador_id', '{{%requisicao}}');
        $this->dropTable('{{%requisicao}}');
    }
}
