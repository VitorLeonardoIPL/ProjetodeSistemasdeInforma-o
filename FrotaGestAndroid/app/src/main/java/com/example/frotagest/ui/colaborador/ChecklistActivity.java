package com.example.frotagest.ui.colaborador;

import android.os.Bundle;
import android.view.View;
import android.widget.AutoCompleteTextView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.Exemplo;
import com.example.frotagest.ui.comum.TopBar;

public class ChecklistActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_checklist);
        TopBar.configurarVoltar(this, getString(R.string.chk_titulo_rececao), "AA-12-BC · QR lido ✓");

        AutoCompleteTextView actEstado = findViewById(R.id.act_estado_geral);
        Exemplo.opcoes(actEstado, getResources().getStringArray(R.array.estado_geral_opcoes));
        actEstado.setText("Bom", false);

        // Legendas dos 4 espaços para fotografias
        legenda(R.id.foto_frente, R.string.chk_foto_frente);
        legenda(R.id.foto_tras, R.string.chk_foto_tras);
        legenda(R.id.foto_esq, R.string.chk_foto_esq);
        legenda(R.id.foto_dir, R.string.chk_foto_dir);

        findViewById(R.id.btn_confirmar).setOnClickListener(v -> finish());
    }

    private void legenda(int idEspaco, int idTexto) {
        View espaco = findViewById(idEspaco);
        TextView tv = espaco.findViewById(R.id.tv_foto_adicionar);
        tv.setText("+\n" + getString(idTexto));
    }
}
