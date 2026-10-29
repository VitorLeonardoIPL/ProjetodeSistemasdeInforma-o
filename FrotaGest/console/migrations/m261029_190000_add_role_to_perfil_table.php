<?php

use yii\db\Migration;

/**
 * Handles adding column `role` to table `{{%perfil}}`.
 */
class m261029_190000_add_role_to_perfil_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //role do utilizador (colaborador, coordenador, tecnico, administrador)
        //e so uma copia para consultar; quem manda no acesso e a tabela auth_assignment
        $this->addColumn('{{%perfil}}', 'role', $this->string(64)->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%perfil}}', 'role');
    }
}
