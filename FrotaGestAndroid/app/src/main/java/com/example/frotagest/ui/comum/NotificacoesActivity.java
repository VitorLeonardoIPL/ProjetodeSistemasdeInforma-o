package com.example.frotagest.ui.comum;

import android.os.Bundle;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.R;

public class NotificacoesActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notificacoes);
        TopBar.configurarVoltar(this, getString(R.string.not_titulo), "3 por ler");
        Exemplo.mostrar(findViewById(android.R.id.content), R.id.btn_top_bar_acao,
                getString(R.string.not_marcar_lidas));

        // Exemplo: 4 notificações (substituir pelos dados da API)
        ListView lvNotificacoes = findViewById(R.id.lv_notificacoes);
        lvNotificacoes.setAdapter(new Exemplo.Adaptador(this,
                R.layout.item_notificacao, 4, null));
    }
}
