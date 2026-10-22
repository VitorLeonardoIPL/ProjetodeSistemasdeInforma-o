package com.example.frotagest.ui.colaborador;

import android.content.Intent;
import android.os.Bundle;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.Exemplo;
import com.example.frotagest.ui.comum.TopBar;

public class RequisicaoDetalheActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_requisicao_detalhe);
        TopBar.configurarVoltar(this, "Pedido #1042", null);
        Exemplo.mostrar(findViewById(android.R.id.content), R.id.tv_top_bar_status,
                getString(R.string.estado_aprovada));
        TextView tvEstado = findViewById(R.id.tv_top_bar_status);
        tvEstado.setBackgroundResource(R.drawable.bg_status_aprovada);
        tvEstado.setTextColor(getColor(R.color.fg_status_apr_text));

        findViewById(R.id.btn_ler_qr).setOnClickListener(v ->
                startActivity(new Intent(this, ChecklistActivity.class)));
    }
}
