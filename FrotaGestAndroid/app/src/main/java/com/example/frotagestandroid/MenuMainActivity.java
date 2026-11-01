package com.example.frotagestandroid;

import android.os.Bundle;
import android.view.View;

import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.content.ContextCompat;

import com.example.frotagestandroid.databinding.ActivityMenuMainBinding;
import com.example.frotagestandroid.databinding.NavHeaderMainBinding;

public class MenuMainActivity extends AppCompatActivity {

    private ActivityMenuMainBinding binding;
    private String email;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

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
