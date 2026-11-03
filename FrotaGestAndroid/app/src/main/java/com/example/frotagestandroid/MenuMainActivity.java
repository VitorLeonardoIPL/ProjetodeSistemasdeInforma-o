package com.example.frotagestandroid;

import android.os.Bundle;
import android.view.Menu;
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
        carregarMenuCoordenador();
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

    //os itens do coordenador so aparecem a quem tem esse role
    //o role ainda nao vem do login (API da Etapa 2), por isso fica escondido
    private void carregarMenuCoordenador() {
        String role=getIntent().getStringExtra("ROLE");
        boolean isCoordenador="coordenador".equals(role);
        binding.navigationView.getMenu().setGroupVisible(R.id.grupoCoordenador, isCoordenador);
    }

    //sino das notificacoes no canto direito da toolbar
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_toolbar, menu);
        return true;
    }

    private void carregarToolbar() {
        setSupportActionBar(binding.toolbar);
        ActionBarDrawerToggle drawerToggle = new ActionBarDrawerToggle(this, binding.drawerLayout, binding.toolbar, R.string.menu_abrir, R.string.menu_fechar);
        binding.drawerLayout.addDrawerListener(drawerToggle);
        drawerToggle.syncState();
        drawerToggle.getDrawerArrowDrawable().setColor(ContextCompat.getColor(this, android.R.color.white));
    }
}
