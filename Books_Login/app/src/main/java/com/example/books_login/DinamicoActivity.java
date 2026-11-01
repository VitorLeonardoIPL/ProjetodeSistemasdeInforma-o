package com.example.books_login;

import android.os.Bundle;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.books_login.databinding.ActivityDinamicoBinding;
import com.example.books_login.databinding.ActivityEstaticoBinding;
import com.example.books_login.modelo.Livro;
import com.example.books_login.modelo.SingletonGestorLivros;

import java.util.ArrayList;

public class DinamicoActivity extends AppCompatActivity {

    private ActivityDinamicoBinding binding;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        //setContentView(R.layout.activity_dinamico);

        binding=ActivityDinamicoBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        setTitle("Livro Dinamico");
        WindowCompat.setDecorFitsSystemWindows(getWindow(), true);

    }

    public void carregarLivro(){
        ArrayList<Livro> livros=SingletonGestorLivros.getInstance().getLivros();
        Livro livro;
        if(livros!=null && livros.size()>0) {
            livro=livros.get(0);
            binding.tvTitulo.setText(livro.getTitulo());
            binding.tvSerie.setText(livro.getSerie());
            binding.tvAutor.setText(livro.getAutor());
            binding.tvAno.setText(livro.getAno()+"");
            binding.imgCapa.setImageResource(livro.getCapa());

        }

    }

}