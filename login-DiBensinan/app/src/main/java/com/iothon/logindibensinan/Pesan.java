package com.iothon.logindibensinan;

import static android.content.ContentValues.TAG;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import com.iothon.logindibensinan.DialogKonfirmasi.LanjutkanPencatatan;

import android.content.Intent;
import android.graphics.Color;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.net.Uri;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.OnFailureListener;
import com.google.android.gms.tasks.OnSuccessListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.firestore.DocumentReference;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;

import java.io.IOException;
import java.net.URI;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Date;
import java.util.HashMap;
import java.util.HashSet;
import java.util.List;
import java.util.Locale;
import java.util.Map;
import java.util.Objects;
import java.util.Set;

public class Pesan extends AppCompatActivity implements LanjutkanPencatatan {

    private Button kirimPesan, linkLokasiMitra;
    private EditText jmlBensinPesan, namaMitra;
    private TextView tvNamaPelanggan, tvLokasi, tvJenisBensin;
    private FirebaseFirestore db;
    private FirebaseAuth ojoLali;
    private String linkLokasi;
    private Spinner listMitra;
    private ArrayList<MitraItem> vMitraList;
    private MitraAdapter mitraAdapter;
    private Bundle dialogBundle;
    private String vtNamaMitra = "johndoe",
            vtEmailMitra = "john_doe123@gmail.com",
            vtJenisBensinMitra = "pertamax, pertalite",
            vtAlamatMitra = "geger kalong",
            vtStokPertalite = "0",
            vtStokPertamax = "0",
            kfNamaMitra = "nama mitra";;
    private final static int hargaPerlalite = 10000;
    private final static int hargaPertamax = 13900;
    public static final String EXTRA_NAMA = "extra_name";
    public static final String EXTRA_JENIS_BENSIN = "extra_jenis_bensin";
    public static final String EXTRA_ALAMAT_PELANGGAN = "extra_alamat_pelanggan";
    public static final String EXTRA_ALAMAT = "extra_alamat";
    public static final String EXTRA_EMAIL = "extra_email";
    public static final String EXTRA_NOHP = "extra_noHP";
    public static final String EXTRA_ID_DOKUMEN = "extra_id_dokumen";
    public static final String EXTRA_LATITUDE = "extra_latitude";
    public static final String EXTRA_LONGITUDE = "extra_longitude";
    public static final String EXTRA_CITY = "extra_city";


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //transparant Statusbar
        requestWindowFeature(1); // baru
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS, // baru
                WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS); // baru
        getWindow().setStatusBarColor(Color.TRANSPARENT);// baru

        setContentView(R.layout.activity_pesan);

        kirimPesan = findViewById(R.id.btn_kirim_pesan);
        tvNamaPelanggan = findViewById(R.id.tv_nama_pelanggan);
        jmlBensinPesan = findViewById(R.id.jml_bensin_pesan);
        tvJenisBensin = findViewById(R.id.tv_jenis_bensin);
        tvLokasi = findViewById(R.id.tv_lokasi);
        linkLokasiMitra = findViewById(R.id.link_lokasi_mitra);
//        namaMitra = findViewById(R.id.nama_mitra_pesan);

        listMitra = findViewById(R.id.list_mitra);
        db = FirebaseFirestore.getInstance();
        ojoLali = FirebaseAuth.getInstance();
        dialogBundle = new Bundle();


        menampilkanInformasiUmum();

        initSpin();

        kirimPesan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if (TextUtils.isEmpty(jmlBensinPesan.getText().toString())){
                    jmlBensinPesan.setError("Jumlah Bensinnya nya diisi dulu mas/mbak");
                    jmlBensinPesan.requestFocus();
                } else {
                    showDialogKonfirmasi();
                }
            }
        });

        linkLokasiMitra.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                pergiKeLink(linkLokasi);
            }
        });

    }

    @Override
    protected void onStart() {
        super.onStart();
        listMitra.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {
                MitraItem clickedItem = (MitraItem) adapterView.getItemAtPosition(i);
                kfNamaMitra = clickedItem.getNamaMitra();
                Log.d("heheheheh", clickedItem.getNamaMitra());
                linkLokasi = clickedItem.getPanggenan();
            }

            @Override
            public void onNothingSelected(AdapterView<?> adapterView) {

            }
        });
    }

    // menampilkan dialog konfirmasi
    private void showDialogKonfirmasi(){
        DialogKonfirmasi dialogKonfirmasi = new DialogKonfirmasi();
        double jumlahBensin = Double.parseDouble(jmlBensinPesan.getText().toString());
        String namaPengguna = getIntent().getStringExtra(EXTRA_NAMA);
        String jenisBensin = getIntent().getStringExtra(EXTRA_JENIS_BENSIN);
        String location = getIntent().getStringExtra(EXTRA_ALAMAT_PELANGGAN);

        int hargaBensin = 1;
        if (jenisBensin.equalsIgnoreCase("pertamax")){
            hargaBensin = hargaPertamax;
        } else {
            hargaBensin = hargaPerlalite;
        }
        dialogBundle.putString("nama",namaPengguna);
        dialogBundle.putString("jenis", jenisBensin);
        dialogBundle.putString("lokasi", location);
        dialogBundle.putString("mitra",kfNamaMitra);
        dialogBundle.putDouble("total", hargaBensin * jumlahBensin);
        dialogKonfirmasi.setArguments(dialogBundle);
        dialogKonfirmasi.show(getSupportFragmentManager(), "dialog konfirmasi");
    }

    // menambahkan data ke database transaksiGelap
    private void tambahData(){
        double jumlahBensin = Double.parseDouble(jmlBensinPesan.getText().toString());
        String namaPengguna = getIntent().getStringExtra(EXTRA_NAMA);
        String jenisBensin = getIntent().getStringExtra(EXTRA_JENIS_BENSIN);
        String location = getIntent().getStringExtra(EXTRA_ALAMAT_PELANGGAN);
        String namaMitra = listMitra.getSelectedItem().toString().trim();
        int hargaBensin = 1;
        if (jenisBensin.equalsIgnoreCase("pertamax")){
            hargaBensin = hargaPertamax;
        } else {
            hargaBensin = hargaPerlalite;
        }
        // Add a new document with a generated id.
        Map<String, Object> data = new HashMap<>();
        data.put("namaUser", namaPengguna);
        data.put("namaMitra", kfNamaMitra);
        data.put("lokasi", location);
        data.put("jenisBensin", jenisBensin);
        data.put("tglPesan", getCurrentDate());
        data.put("totalBayar", jumlahBensin * hargaBensin);
        data.put("totalLiter", jumlahBensin);

        db.collection("transaksiGelap")
                .add(data)
                .addOnSuccessListener(new OnSuccessListener<DocumentReference>() {
                    @Override
                    public void onSuccess(DocumentReference documentReference) {
                        Toast.makeText(Pesan.this, "Data berhasil direkam dengan ID: " + documentReference.getId(), Toast.LENGTH_SHORT).show();
                    }
                })
                .addOnFailureListener(new OnFailureListener() {
                    @Override
                    public void onFailure(@NonNull Exception e) {
                        System.out.println("Error adding document" + e);
                        Toast.makeText(Pesan.this, "Data gagal direkam dengan error : " + e, Toast.LENGTH_SHORT).show();

                    }
                });
    }

    // fungsi untuk menetapkan waktu dan tanggal transaksi
    private String getCurrentDate() {
        DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss", Locale.getDefault());
        Date date = new Date();

        return dateFormat.format(date);
    }

    // mengisi isi spinner
    public void initSpin() {
        vMitraList = new ArrayList<>();
        String jnsBensin = getIntent().getStringExtra(EXTRA_JENIS_BENSIN);
        Query spinnerMitraMerdeka = db.collection("mitra");
        spinnerMitraMerdeka.
                get().
                addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
            @Override
            public void onComplete(@NonNull Task<QuerySnapshot> task) {
                if (task.isSuccessful()){
                    for (QueryDocumentSnapshot document : task.getResult()){
                        if(document.getData().get("jenisBensin").toString().contains(jnsBensin.toLowerCase())){
                            vtNamaMitra = document.getData().get("namaMitra").toString();
                            vtEmailMitra = document.getData().get("emailMitra").toString();
                            vtAlamatMitra = document.getData().get("lokasiMitra").toString();
                            vtJenisBensinMitra = document.getData().get("jenisBensin").toString();
                            vtStokPertamax = document.getData().get("stokPertamax").toString();
                            vtStokPertalite = document.getData().get("stokPertalite").toString();
                        }
                        MitraItem mitraItem = new MitraItem(vtNamaMitra, vtEmailMitra, vtJenisBensinMitra, vtAlamatMitra, vtStokPertalite, vtStokPertamax);
                        if (!mitraItem.getNamaMitra().equals("johndoe")){
                            vMitraList.add(mitraItem);
                        }

                    }
                    mitraAdapter = new MitraAdapter(Pesan.this, vMitraList);
                    listMitra.setAdapter(mitraAdapter);
                } else {
                    Log.d(TAG, "Error getting documents: ", task.getException());
                }
            }
        });
    }

    @Override
    public void lanjutkan() {
        tambahData();
        Toast.makeText(Pesan.this, "Pesanan segera diproses. Silakan Tunggu!", Toast.LENGTH_SHORT).show();
        Intent dashboardData = new Intent(Pesan.this, Dashboard.class);
        dashboardData.putExtra(Profile.EXTRA_NAMA, getIntent().getStringExtra(EXTRA_NAMA));
        dashboardData.putExtra(Profile.EXTRA_EMAIL, getIntent().getStringExtra(EXTRA_EMAIL));
        dashboardData.putExtra(Profile.EXTRA_ALAMAT, getIntent().getStringExtra(EXTRA_ALAMAT));
        dashboardData.putExtra(Profile.EXTRA_ID_DOKUMEN, getIntent().getStringExtra(EXTRA_ID_DOKUMEN));
        dashboardData.putExtra(Profile.EXTRA_NOHP, getIntent().getStringExtra(EXTRA_NOHP));
        startActivity(dashboardData);
    }

    private void menampilkanInformasiUmum(){
        tvNamaPelanggan.setText(getIntent().getStringExtra(EXTRA_NAMA));
        tvLokasi.setText(getIntent().getStringExtra(EXTRA_ALAMAT_PELANGGAN));
        tvJenisBensin.setText(getIntent().getStringExtra(EXTRA_JENIS_BENSIN));
    }

    private void pergiKeLink(String s){
        Uri uri = Uri.parse(s);
        startActivity(new Intent(Intent.ACTION_VIEW, uri));
    }

}