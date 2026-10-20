<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%viatura}}`.
 */
class m261020_194339_create_viatura_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela viatura
        $this->createTable('{{%viatura}}', [
            'id' => $this->primaryKey(),
            //FK: categoria da viatura
            'categoria_id' => $this->integer()->notNull(),
            //matricula, nao se repete
            'matricula' => $this->string()->notNull()->unique(),
            'marca' => $this->string()->notNull(),
            'modelo' => $this->string()->notNull(),
            //gasolina, gasoleo, eletrico...
            'combustivel' => $this->string()->notNull(),
            //texto livre com as caracteristicas
            'caracteristicas' => $this->text(),
            //caminho da fotografia
            'foto' => $this->string(),
            //codigo que identifica a viatura na app
            'qr_code' => $this->string(),
            //disponivel, em manutencao ou indisponivel
            'estado' => $this->string()->notNull()->defaultValue('disponivel'),
            //quilometros atuais
            'km_atual' => $this->integer()->notNull()->defaultValue(0),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: viatura.categoria_id -> categoria.id
        $this->createIndex('idx-viatura-categoria_id', '{{%viatura}}', 'categoria_id');
        $this->addForeignKey(
            'fk-viatura-categoria_id',
            '{{%viatura}}',
            'categoria_id',
            '{{%categoria}}',
            'id'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-viatura-categoria_id', '{{%viatura}}');
        $this->dropIndex('idx-viatura-categoria_id', '{{%viatura}}');
        $this->dropTable('{{%viatura}}');
    }
}
