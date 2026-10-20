package com.example.frotagest.ui.admin;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.example.frotagest.R;
import com.example.frotagest.ui.comum.Exemplo;
import com.example.frotagest.ui.comum.TopBar;

public class AdminSistemaFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_admin_sistema, container, false);
        TopBar.configurar(view, getString(R.string.adm_titulo), "Administrador · Sofia Reis");
        Exemplo.mostrar(view, R.id.tv_badge_notificacoes, "1");

        // Exemplo: 5 serviços e 3 alertas
        Exemplo.preencher(view.findViewById(R.id.ll_servicos), R.layout.item_servico_estado, 5);
        Exemplo.preencher(view.findViewById(R.id.ll_notificacoes_sistema),
                R.layout.item_notificacao_sistema, 3);
        return view;
    }
}
