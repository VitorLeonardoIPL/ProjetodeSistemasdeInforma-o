<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%localizacao}}`.
 */
class m261020_195057_create_localizacao_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela localizacao
        $this->createTable('{{%localizacao}}', [
            'id' => $this->primaryKey(),
            //FK: utilizacao da viatura
            'atribuicao_id' => $this->integer()->notNull(),
            'latitude' => $this->float()->notNull(),
            'longitude' => $this->float()->notNull(),
            'data_hora' => $this->dateTime()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: localizacao.atribuicao_id -> atribuicao.id
        $this->createIndex('idx-localizacao-atribuicao_id', '{{%localizacao}}', 'atribuicao_id');
        $this->addForeignKey(
            'fk-localizacao-atribuicao_id',
            '{{%localizacao}}',
            'atribuicao_id',
            '{{%atribuicao}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-localizacao-atribuicao_id', '{{%localizacao}}');
        $this->dropIndex('idx-localizacao-atribuicao_id', '{{%localizacao}}');
        $this->dropTable('{{%localizacao}}');
    }
}
