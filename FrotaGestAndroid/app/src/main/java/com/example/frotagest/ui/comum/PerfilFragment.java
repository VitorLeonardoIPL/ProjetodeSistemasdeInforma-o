package com.example.frotagest.ui.comum;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.example.frotagest.R;
import com.example.frotagest.ui.auth.LoginActivity;

public class PerfilFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_perfil, container, false);
        TopBar.configurar(view, getString(R.string.perfil_titulo), null);
        Exemplo.mostrar(view, R.id.tv_badge_notificacoes, "3");

        view.findViewById(R.id.row_servidor).setOnClickListener(v ->
                startActivity(new Intent(requireContext(), ConfiguracaoActivity.class)));
        view.findViewById(R.id.btn_terminar_sessao).setOnClickListener(v -> {
            Intent intent = new Intent(requireContext(), LoginActivity.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intent);
        });
        return view;
    }
}
