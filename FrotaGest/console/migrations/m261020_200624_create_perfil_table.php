<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%perfil}}`.
 */
class m261020_200624_create_perfil_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //criar a tabela perfil
        $this->createTable('{{%perfil}}', [
            'id' => $this->primaryKey(),
            //FK: utilizador a que o perfil pertence (1 para 1)
            'user_id' => $this->integer()->notNull()->unique(),
            'nome' => $this->string()->notNull(),
            'telemovel' => $this->string(),
            //usado na taxa de ocupacao por departamento
            'departamento' => $this->string(),
            //numero da carta de conducao
            'n_carta' => $this->string(),
            'validade_carta' => $this->date(),
            //token das notificacoes da app
            'token_push' => $this->string(),
        ], 'ENGINE=InnoDB');

        //indice e chave estrangeira: perfil.user_id -> user.id
        $this->createIndex('idx-perfil-user_id', '{{%perfil}}', 'user_id');
        $this->addForeignKey(
            'fk-perfil-user_id',
            '{{%perfil}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        //desfazer pela ordem inversa do safeUp
        $this->dropForeignKey('fk-perfil-user_id', '{{%perfil}}');
        $this->dropIndex('idx-perfil-user_id', '{{%perfil}}');
        $this->dropTable('{{%perfil}}');
    }
}
