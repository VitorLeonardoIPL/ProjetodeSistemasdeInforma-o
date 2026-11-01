package com.example.books_login;

import android.os.Bundle;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.books_login.databinding.ActivityEstaticoBinding;

public class EstaticoActivity extends AppCompatActivity {

    private ActivityEstaticoBinding binding;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);

        //substitui setContentView(R.layout.activity_estatico);
        binding=ActivityEstaticoBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        //setContentView(R.layout.activity_estatico);

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        setTitle("Livro Estatico");
        WindowCompat.setDecorFitsSystemWindows(getWindow(), true);

        binding.tvTitulo.setText("Programar Android em AMSI");
        binding.tvSerie.setText("Android Saga");
        binding.tvAutor.setText("Equipa de AMSI");
        binding.tvAno.setText("2019");
        binding.imgCapa.setImageResource(R.drawable.programarandroid1);
    }
}