package com.example.frotagest;

import android.os.Bundle;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.fragment.app.Fragment;

import com.example.frotagest.ui.admin.AdminSistemaFragment;
import com.example.frotagest.ui.colaborador.RequisicoesFragment;
import com.example.frotagest.ui.colaborador.ViagemFragment;
import com.example.frotagest.ui.comum.PerfilFragment;
import com.example.frotagest.ui.coordenador.MapaFragment;
import com.example.frotagest.ui.coordenador.PedidosCoordFragment;
import com.google.android.material.bottomnavigation.BottomNavigationView;

/**
 * Contentor principal após o login: barra inferior por perfil e um Fragment por separador.
 */
public class MainActivity extends AppCompatActivity {

    public static final String EXTRA_PERFIL = "perfil";
    public static final String PERFIL_COLABORADOR = "colaborador";
    public static final String PERFIL_COORDENADOR = "coordenador";
    public static final String PERFIL_ADMIN = "admin";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_main);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });

        String perfil = getIntent().getStringExtra(EXTRA_PERFIL);
        if (perfil == null) {
            perfil = PERFIL_COLABORADOR;
        }

        BottomNavigationView bottomNav = findViewById(R.id.bottom_nav);
        bottomNav.getMenu().clear();
        if (PERFIL_COORDENADOR.equals(perfil)) {
            bottomNav.inflateMenu(R.menu.menu_bottom_coordenador);
        } else if (PERFIL_ADMIN.equals(perfil)) {
            bottomNav.inflateMenu(R.menu.menu_bottom_admin);
        } else {
            bottomNav.inflateMenu(R.menu.menu_bottom_colaborador);
        }

        final String perfilAtual = perfil;
        bottomNav.setOnItemSelectedListener(item -> {
            mostrarFragment(criarFragment(item.getItemId(), perfilAtual));
            return true;
        });

        if (savedInstanceState == null) {
            // Primeiro separador do perfil (Pedidos ou Sistema)
            mostrarFragment(criarFragment(bottomNav.getMenu().getItem(0).getItemId(), perfil));
        }
    }

    private Fragment criarFragment(int itemId, String perfil) {
        if (itemId == R.id.nav_viagem) {
            return new ViagemFragment();
        } else if (itemId == R.id.nav_mapa) {
            return new MapaFragment();
        } else if (itemId == R.id.nav_perfil) {
            return new PerfilFragment();
        } else if (itemId == R.id.nav_sistema) {
            return new AdminSistemaFragment();
        } else if (PERFIL_COORDENADOR.equals(perfil)) {
            return new PedidosCoordFragment();
        }
        return new RequisicoesFragment();
    }

    private void mostrarFragment(Fragment fragment) {
        getSupportFragmentManager()
                .beginTransaction()
                .replace(R.id.fragment_container, fragment)
                .commit();
    }
}
