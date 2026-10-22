package com.example.frotagest.ui.colaborador;

import android.content.Intent;
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

public class ViagemFragment extends Fragment {

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container,
                             @Nullable Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.fragment_viagem, container, false);
        TopBar.configurar(view, getString(R.string.via_titulo), "#1031 · EG-23-KL · Coimbra");
        Exemplo.mostrar(view, R.id.tv_top_bar_status, getString(R.string.estado_em_curso));
        Exemplo.mostrar(view, R.id.tv_badge_notificacoes, "2");
        Exemplo.mostrar(view, R.id.tv_banner_offline,
                "Sem ligação. 3 registos guardados no dispositivo.");

        // Exemplo: 1 fatura registada
        Exemplo.preencher(view.findViewById(R.id.ll_faturas), R.layout.item_fatura, 1);

        view.findViewById(R.id.btn_entregar).setOnClickListener(v ->
                startActivity(new Intent(requireContext(), ChecklistActivity.class)));
        return view;
    }
}
