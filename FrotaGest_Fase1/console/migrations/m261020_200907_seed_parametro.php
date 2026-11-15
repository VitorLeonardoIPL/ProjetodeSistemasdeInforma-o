<?php

use yii\db\Migration;

class m261020_200907_seed_parametro extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //valores por omissao dos parametros; o administrador altera-os depois no back-office
        $this->batchInsert('{{%parametro}}', ['chave', 'valor', 'atualizado_em'], [
            ['alerta_dias_seguro', '30', date('Y-m-d H:i:s')],
            ['alerta_dias_inspecao', '30', date('Y-m-d H:i:s')],
            ['alerta_dias_iuc', '30', date('Y-m-d H:i:s')],
            ['alerta_dias_revisao', '30', date('Y-m-d H:i:s')],
            ['requisicao_antecedencia_min_dias', '1', date('Y-m-d H:i:s')],
            ['requisicao_duracao_max_dias', '15', date('Y-m-d H:i:s')],
            ['viatura_parada_dias', '30', date('Y-m-d H:i:s')],
            ['localizacao_intervalo_seg', '60', date('Y-m-d H:i:s')],
            ['sessao_expiracao_min', '60', date('Y-m-d H:i:s')],
            ['logs_retencao_dias', '90', date('Y-m-d H:i:s')],
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%parametro}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m261020_200907_seed_parametro cannot be reverted.\n";

        return false;
    }
    */
}
