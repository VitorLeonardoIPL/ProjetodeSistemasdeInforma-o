package com.example.frotagest.ui.comum;

import android.app.Activity;
import android.content.Intent;
import android.view.View;
import android.widget.TextView;

import com.example.frotagest.R;

/**
 * Preenche os cabeçalhos reutilizáveis (layout_top_bar e layout_top_bar_back).
 */
public final class TopBar {

    private TopBar() {
    }

    /** Cabeçalho dos separadores principais, com o sino de notificações. */
    public static void configurar(View raiz, String titulo, String subtitulo) {
        TextView tvTitulo = raiz.findViewById(R.id.tv_top_bar_title);
        tvTitulo.setText(titulo);

        View llSubtitulo = raiz.findViewById(R.id.ll_top_bar_subtitle);
        if (subtitulo != null) {
            TextView tvSubtitulo = raiz.findViewById(R.id.tv_top_bar_subtitle);
            tvSubtitulo.setText(subtitulo);
            llSubtitulo.setVisibility(View.VISIBLE);
        } else {
            llSubtitulo.setVisibility(View.GONE);
        }

        raiz.findViewById(R.id.btn_notificacoes).setOnClickListener(v ->
                v.getContext().startActivity(new Intent(v.getContext(), NotificacoesActivity.class)));
    }

    /** Cabeçalho dos ecrãs de detalhe, com a seta de voltar. */
    public static void configurarVoltar(Activity activity, String titulo, String subtitulo) {
        TextView tvTitulo = activity.findViewById(R.id.tv_top_bar_title);
        tvTitulo.setText(titulo);

        TextView tvSubtitulo = activity.findViewById(R.id.tv_top_bar_subtitle);
        if (subtitulo != null) {
            tvSubtitulo.setText(subtitulo);
            tvSubtitulo.setVisibility(View.VISIBLE);
        } else {
            tvSubtitulo.setVisibility(View.GONE);
        }

        activity.findViewById(R.id.btn_voltar).setOnClickListener(v -> activity.finish());
    }
}
