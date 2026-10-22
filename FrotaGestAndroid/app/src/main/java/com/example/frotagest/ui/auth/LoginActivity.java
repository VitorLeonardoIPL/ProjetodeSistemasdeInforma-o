package com.example.frotagest.ui.auth;

import android.content.Intent;
import android.os.Bundle;
import android.widget.EditText;

import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagest.MainActivity;
import com.example.frotagest.R;
import com.example.frotagest.ui.comum.ConfiguracaoActivity;

/**
 * Ecrã de entrada (M-Login).
 * Provisório: o perfil é escolhido pelo email até existir o login na API.
 *   email com "coord" → Coordenador, com "admin" → Administrador, outro → Colaborador
 */
public class LoginActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        EditText etEmail = findViewById(R.id.et_email);

        findViewById(R.id.btn_entrar).setOnClickListener(v -> {
            String email = etEmail.getText().toString().toLowerCase();
            String perfil = MainActivity.PERFIL_COLABORADOR;
            if (email.contains("coord")) {
                perfil = MainActivity.PERFIL_COORDENADOR;
            } else if (email.contains("admin")) {
                perfil = MainActivity.PERFIL_ADMIN;
            }

            Intent intent = new Intent(this, MainActivity.class);
            intent.putExtra(MainActivity.EXTRA_PERFIL, perfil);
            startActivity(intent);
            finish();
        });

        findViewById(R.id.btn_configuracao).setOnClickListener(v ->
                startActivity(new Intent(this, ConfiguracaoActivity.class)));
    }
}
