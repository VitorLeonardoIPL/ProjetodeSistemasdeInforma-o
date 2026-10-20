package com.example.frotagest.ui.coordenador;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.Exemplo;
import com.example.frotagest.ui.comum.TopBar;

public class PedidoCoordActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pedido_coord);
        TopBar.configurarVoltar(this, "Pedido #1048", null);
        Exemplo.mostrar(findViewById(android.R.id.content), R.id.tv_top_bar_status,
                getString(R.string.estado_pendente));

        Exemplo.opcoes(findViewById(R.id.act_condutor),
                "Ana Ribeiro · L-123456", "Carla Nunes · L-552301");
        Exemplo.opcoes(findViewById(R.id.act_viatura),
                "AA-12-BC · Renault Clio (livre)", "BD-45-EF · Peugeot 208 (livre)");
        Exemplo.opcoes(findViewById(R.id.act_motivo_recusa),
                getResources().getStringArray(R.array.motivos_recusa));

        View llAprovar = findViewById(R.id.ll_aprovar);
        View llRecusar = findViewById(R.id.ll_recusar);
        View botoesAprovar = findViewById(R.id.ll_botoes_aprovar);
        View botoesRecusar = findViewById(R.id.ll_botoes_recusar);

        // Recusar: troca para o modo recusa (motivo obrigatório)
        findViewById(R.id.btn_recusar).setOnClickListener(v -> {
            llAprovar.setVisibility(View.GONE);
            botoesAprovar.setVisibility(View.GONE);
            llRecusar.setVisibility(View.VISIBLE);
            botoesRecusar.setVisibility(View.VISIBLE);
        });
        findViewById(R.id.btn_voltar_aprovar).setOnClickListener(v -> {
            llRecusar.setVisibility(View.GONE);
            botoesRecusar.setVisibility(View.GONE);
            llAprovar.setVisibility(View.VISIBLE);
            botoesAprovar.setVisibility(View.VISIBLE);
        });
        findViewById(R.id.btn_aprovar).setOnClickListener(v -> finish());
        findViewById(R.id.btn_confirmar_recusa).setOnClickListener(v -> finish());

        findViewById(R.id.btn_ver_disponiveis).setOnClickListener(v ->
                startActivity(new Intent(this, CondutoresDisponiveisActivity.class)));
    }
}
