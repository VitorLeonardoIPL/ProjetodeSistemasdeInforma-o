package com.example.books_login;

import android.os.Bundle;
import android.view.View;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;

import com.example.books_login.databinding.ActivityMenuMainBinding;
import com.example.books_login.databinding.NavHeaderMainBinding;

public class MenuMainActivity extends AppCompatActivity {

    private ActivityMenuMainBinding binding;
    private String email;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        /*EdgeToEdge.enable(this);
        setContentView(R.layout.activity_menu_main);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });*/

        binding=ActivityMenuMainBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());
        carregarToolbar();
        carregarCabecalho();
    }

    //para preencher com o email
    private void carregarCabecalho() {
        View headerView;
        email=getIntent().getStringExtra("EMAIL").toString();
        if(email!=null && binding.navigationView.getHeaderCount()>0){
           headerView=binding.navigationView.getHeaderView(0);
           NavHeaderMainBinding headerBinding=NavHeaderMainBinding.bind(headerView);
            headerBinding.tvEmail.setText(email);
        }
    }

    private void carregarToolbar() {
        setSupportActionBar(binding.toolbar);
        ActionBarDrawerToggle drawerToggle = new ActionBarDrawerToggle(this, binding.drawerLayout, binding.toolbar, R.string.menu_abrir, R.string.menu_fechar);
        binding.drawerLayout.addDrawerListener(drawerToggle);
        drawerToggle.syncState();
        drawerToggle.getDrawerArrowDrawable().setColor(ContextCompat.getColor(this, android.R.color.white));
    }
}