package com.iothon.logindibensinan;

import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatDialogFragment;


public class DialogKonfirmasi extends AppCompatDialogFragment {
    protected TextView namaPelangganDialog, namaMitraDialog, jenisBensinDialog, alamatAntarDialog, totalBayarDialog;
    protected LanjutkanPencatatan listener;
    protected Bundle bundleDariPesan;
    protected String vNamaPengguna, vJenisBensin, vLokasiAntar, vNamaMitra;
    protected double vTotalBayar;

    @Override
    public Dialog onCreateDialog(Bundle savedInstanceState) {
        AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
        LayoutInflater inflater = getActivity().getLayoutInflater();
        View view = inflater.inflate(R.layout.fragment_dialog_konfirmasi, null);
        namaPelangganDialog = view.findViewById(R.id.nama_pelanggan_dialog);
        namaMitraDialog = view.findViewById(R.id.nama_mitra_dialog);
        jenisBensinDialog = view.findViewById(R.id.jenis_bensin_dialog);
        alamatAntarDialog = view.findViewById(R.id.alamat_antar_dialog);
        totalBayarDialog = view.findViewById(R.id.total_bayar_dialog);

        // get the bundle
        bundleDariPesan = getArguments();
        if (bundleDariPesan != null){
            vNamaPengguna = bundleDariPesan.getString("nama");
            vJenisBensin = bundleDariPesan.getString("jenis");
            vLokasiAntar = bundleDariPesan.getString("lokasi");
            vNamaMitra = bundleDariPesan.getString("mitra");
            vTotalBayar = bundleDariPesan.getDouble("total");
        } else {
            vNamaPengguna = "kosong";
            vJenisBensin = "kosong";
            vLokasiAntar = "kosong";
            vNamaMitra = "kosong";
            vTotalBayar = 0.0;
        }

        // set the text
        namaPelangganDialog.setText(String.format("Nama Pembeli : %s", vNamaPengguna));
        namaMitraDialog.setText(String.format("Nama Mitra : %s", vNamaMitra));
        jenisBensinDialog.setText(String.format("Jenis Bensin : %s", vJenisBensin));
        alamatAntarDialog.setText(String.format("Alamat : %s", vLokasiAntar));
        totalBayarDialog.setText(String.format("Total Harga : %.2f", vTotalBayar));

        builder.setView(view)
                .setNegativeButton("cancel", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        dialogInterface.cancel();

                    }
                })
                .setPositiveButton("ok", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialogInterface, int i) {
                        listener.lanjutkan();
                    }
                });

        return builder.create();
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);

        try {
            listener = (LanjutkanPencatatan) context;
        } catch (ClassCastException e) {
            throw new ClassCastException(context.toString() + "must implement lanjutkanPencatatan");
        }
    }

    public interface LanjutkanPencatatan {
        void lanjutkan();
    }
}