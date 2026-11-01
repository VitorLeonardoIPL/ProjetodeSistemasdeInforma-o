package com.example.books_login;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;
import android.widget.Toast;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.books_login.databinding.ActivityLoginBinding;

public class LoginActivity extends AppCompatActivity {

    //Fomos buscar a class ActivityLoginBinding que foi posta automatica quando ativado o Binding
    private ActivityLoginBinding binding;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);

        //setContentView(R.layout.activity_login);

        //inicializacao do ViewBinding

        binding=ActivityLoginBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

     //   ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
         //   Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
         //   v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
         //   return insets;
      //  });


        /* EditText etEmail=findViewById(R.id.etEmail);
        //etEmail.getText().toString();*/

        //Vamos substituir pelo ViewBinding em Buiçd.grandle.kts


    }

    public void onClickLogin(View view) {

        //2.5

        //Acesso ao componente etEmail atraves do ViewBinding

    String email=binding.etEmail.getText().toString();
    String password=binding.etPassword.getText().toString();
    if(!isEmailValido(email)){
        binding.etEmail.setError("Email inválido");
        return;
    }
        if(!isPasswordValida(password)) {
            binding.etPassword.setError("Password inválida");
            return;
        }
      //  Toast.makeText(this, "Login Efectuado com sucesso", Toast.LENGTH_SHORT).show();

        //Criei um intent para a nova atividade
        //Como nao preciso de retornar nada, uso o startAtivitu
        //enviei no Bundle o email (Chave/valor)

        Intent intent=new Intent(this, MenuMainActivity.class);
        intent.putExtra("EMAIL",email);
        startActivity(intent);
        finish();

    }

    //ex 2.3

//classe Patterns se permite ver se tem um padrao. neste caso se o que é endereço é email
    public boolean isEmailValido(String email){
        if(email==null)
            return  false;
        return Patterns.EMAIL_ADDRESS.matcher(email).matches();

    }

    //ex 2.4

    //Exigir que tenha 4 caracteres
    public boolean isPasswordValida(String pass){
        if(pass==null)
            return  false;
        return pass.length()>=4;
    }


}
