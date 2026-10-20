<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%alerta}}`.
 */
class m261020_195135_create_alerta_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela alerta
        $this->createTable('{{%alerta}}', [
            'id' => $this->primaryKey(),
            //FK: viatura a que o alerta se refere
            'viatura_id' => $this->integer()->notNull(),
            //seguro, inspecao, iuc ou revisao
            'tipo' => $this->string()->notNull(),
            'descricao' => $this->string(),
            //data em que o documento expira
            'data_limite' => $this->date(),
            //quando o sistema gerou o alerta
            'data_geracao' => $this->dateTime()->notNull(),
            //ex.: ativo, resolvido
            'estado' => $this->string()->notNull(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: alerta.viatura_id -> viatura.id
        $this->createIndex('idx-alerta-viatura_id', '{{%alerta}}', 'viatura_id');
        $this->addForeignKey(
            'fk-alerta-viatura_id',
            '{{%alerta}}',
            'viatura_id',
            '{{%viatura}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-alerta-viatura_id', '{{%alerta}}');
        $this->dropIndex('idx-alerta-viatura_id', '{{%alerta}}');
        $this->dropTable('{{%alerta}}');
    }
}
