package com.example.frotagest.ui.comum;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.R;

public class ConfiguracaoActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_configuracao);
        TopBar.configurarVoltar(this, getString(R.string.cfg_titulo), null);

        findViewById(R.id.btn_guardar).setOnClickListener(v -> finish());
    }
}
