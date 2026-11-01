package com.example.frotagestandroid;

import android.content.Intent;
import android.os.Bundle;
import android.util.Patterns;
import android.view.View;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;

import com.example.frotagestandroid.databinding.ActivityLoginBinding;

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

    }

    public void onClickLogin(View view) {

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

        //Criei um intent para a nova atividade
        //Como nao preciso de retornar nada, uso o startAtivity
        //enviei no Bundle o email (Chave/valor)

        Intent intent=new Intent(this, MenuMainActivity.class);
        intent.putExtra("EMAIL",email);
        startActivity(intent);
        finish();

    }

    //classe Patterns se permite ver se tem um padrao. neste caso se o que é endereço é email
    public boolean isEmailValido(String email){
        if(email==null)
            return  false;
        return Patterns.EMAIL_ADDRESS.matcher(email).matches();

    }

    //Exigir que tenha 4 caracteres
    public boolean isPasswordValida(String pass){
        if(pass==null)
            return  false;
        return pass.length()>=4;
    }


}
