package com.example.frotagest.ui.coordenador;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.Exemplo;
import com.example.frotagest.ui.comum.TopBar;
import com.google.android.material.chip.Chip;

public class CondutoresDisponiveisActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_condutores_disponiveis);
        TopBar.configurarVoltar(this, getString(R.string.cond_titulo), "Pedido #1048 · Ana Ribeiro");

        Chip chipDisponiveis = findViewById(R.id.chip_disponiveis);
        chipDisponiveis.setText(getString(R.string.cond_disponiveis, 2));
        Chip chipIndisponiveis = findViewById(R.id.chip_indisponiveis);
        chipIndisponiveis.setText(getString(R.string.cond_indisponiveis, 4));

        // Exemplo: 2 condutores disponíveis
        Exemplo.preencher(findViewById(R.id.ll_condutores), R.layout.item_condutor, 2);

        findViewById(R.id.btn_usar_condutor).setOnClickListener(v -> finish());
    }
}
