<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fatura_combustivel}}`.
 */
class m261020_195041_create_fatura_combustivel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela fatura_combustivel
        $this->createTable('{{%fatura_combustivel}}', [
            'id' => $this->primaryKey(),
            //FK: utilizacao da viatura
            'atribuicao_id' => $this->integer()->notNull(),
            //ficheiro da fatura (PDF, JPG ou PNG)
            'fotografia' => $this->string()->notNull(),
            //pode ser corrigido a mao
            'litros' => $this->float(),
            //pode ser corrigido a mao
            'valor' => $this->float(),
            'data_registo' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: fatura_combustivel.atribuicao_id -> atribuicao.id
        $this->createIndex('idx-fatura_combustivel-atribuicao_id', '{{%fatura_combustivel}}', 'atribuicao_id');
        $this->addForeignKey(
            'fk-fatura_combustivel-atribuicao_id',
            '{{%fatura_combustivel}}',
            'atribuicao_id',
            '{{%atribuicao}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-fatura_combustivel-atribuicao_id', '{{%fatura_combustivel}}');
        $this->dropIndex('idx-fatura_combustivel-atribuicao_id', '{{%fatura_combustivel}}');
        $this->dropTable('{{%fatura_combustivel}}');
    }
}
