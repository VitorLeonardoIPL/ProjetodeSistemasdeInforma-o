<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%checklist}}`.
 */
class m261020_195003_create_checklist_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela checklist
        $this->createTable('{{%checklist}}', [
            'id' => $this->primaryKey(),
            //FK: atribuicao a que pertence
            'atribuicao_id' => $this->integer()->notNull(),
            //rececao (check-in) ou entrega (check-out)
            'tipo' => $this->string()->notNull(),
            //quilometros lidos
            'km' => $this->integer()->notNull(),
            'data_hora' => $this->dateTime()->notNull(),
            //estado da viatura
            'estado_geral' => $this->string()->notNull(),
            //documentos a bordo confirmados
            'docs_a_bordo' => $this->boolean()->notNull()->defaultValue(0),
            'observacoes' => $this->string(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: checklist.atribuicao_id -> atribuicao.id
        $this->createIndex('idx-checklist-atribuicao_id', '{{%checklist}}', 'atribuicao_id');
        $this->addForeignKey(
            'fk-checklist-atribuicao_id',
            '{{%checklist}}',
            'atribuicao_id',
            '{{%atribuicao}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-checklist-atribuicao_id', '{{%checklist}}');
        $this->dropIndex('idx-checklist-atribuicao_id', '{{%checklist}}');
        $this->dropTable('{{%checklist}}');
    }
}
