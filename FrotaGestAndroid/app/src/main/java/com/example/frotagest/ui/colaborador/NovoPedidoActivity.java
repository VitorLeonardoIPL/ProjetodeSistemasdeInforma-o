package com.example.frotagest.ui.colaborador;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.TopBar;

public class NovoPedidoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_novo_pedido);
        TopBar.configurarVoltar(this, getString(R.string.novo_titulo), null);

        findViewById(R.id.btn_submeter).setOnClickListener(v -> finish());
    }
}
