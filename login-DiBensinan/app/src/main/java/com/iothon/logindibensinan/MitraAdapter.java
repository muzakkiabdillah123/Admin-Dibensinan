package com.iothon.logindibensinan;


import android.annotation.SuppressLint;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import java.util.ArrayList;

public class MitraAdapter extends ArrayAdapter<MitraItem> {
    public MitraAdapter(Context context, ArrayList<MitraItem> countryList) {
        super(context, 0, countryList);
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        return initView(position, convertView, parent);
    }

    @Override
    public View getDropDownView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        return initView(position, convertView, parent);
    }

    @SuppressLint("DefaultLocale")
    private View initView(int position, View convertView, ViewGroup parent) {
        if (convertView == null) {
            convertView = LayoutInflater.from(getContext()).inflate(
                    R.layout.list_mitra_item, parent, false
            );
        }

        TextView tvLokasiMitra = convertView.findViewById(R.id.lokasi_item);
        TextView tvNamaMitra = convertView.findViewById(R.id.nama_mitra_item);

        MitraItem currentItem = getItem(position);

        if (currentItem != null) {
            tvNamaMitra.setText(currentItem.getNamaMitra());
            if(currentItem.getJenisBensin().contains("pertamax")){
                tvLokasiMitra.setText(String.format("Stok Bensin : %s",currentItem.getStokPertamax()));
            } else {
                tvLokasiMitra.setText(String.format("Stok Bensin : %s", currentItem.getStokPertalite()));
            }
        }

        return convertView;
    }
}
