package com.iothon.logindibensinan;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.firestore.FirebaseFirestore;


public class Dashboard extends AppCompatActivity {

    private TextView haloOm;
    FirebaseAuth ojoLali;
    FirebaseUser userSekarang;
    FirebaseFirestore db;
    Button kePesanPertamax, kePesanPertalite;
    ImageView imageProfile;
    public static final String EXTRA_NAMA = "extra_name";
    public static final String EXTRA_ALAMAT = "extra_alamat";
    public static final String EXTRA_EMAIL = "extra_email";
    public static final String EXTRA_NOHP = "extra_noHP";
    public static final String EXTRA_ID_DOKUMEN = "extra_id_dokumen";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //transparant Statusbar
        requestWindowFeature(1); // baru
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS, // baru
                WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS); // baru
        getWindow().setStatusBarColor(Color.TRANSPARENT);// baru

        setContentView(R.layout.activity_dashboard);

        ojoLali = FirebaseAuth.getInstance();
        haloOm = findViewById(R.id.salamSatuJiwa);
        userSekarang = ojoLali.getCurrentUser();
        imageProfile = (ImageView) findViewById(R.id.Profile);
        kePesanPertamax = findViewById(R.id.pesan_kasana_lokasi2);//
        kePesanPertalite = findViewById(R.id.pesan_kasana_lokasi);//
        db = FirebaseFirestore.getInstance();

        // fungsi untuk menampilkan Nama pada dashboard
        tampilkanNama();

        // Tombol untuk menuju ke Profile
        imageProfile.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent iProfile = new Intent(Dashboard.this,Profile.class);
                iProfile.putExtra(Profile.EXTRA_NAMA, getIntent().getStringExtra(EXTRA_NAMA));
                iProfile.putExtra(Profile.EXTRA_EMAIL, getIntent().getStringExtra(EXTRA_EMAIL));
                iProfile.putExtra(Profile.EXTRA_ALAMAT, getIntent().getStringExtra(EXTRA_ALAMAT));
                iProfile.putExtra(Profile.EXTRA_ID_DOKUMEN, getIntent().getStringExtra(EXTRA_ID_DOKUMEN));
                iProfile.putExtra(Profile.EXTRA_NOHP, getIntent().getStringExtra(EXTRA_NOHP));
                startActivity(iProfile);
            }
        });

        kePesanPertalite.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent pertaliteIintent = new Intent(Dashboard.this, LokasiOrder.class);
                pertaliteIintent.putExtra(LokasiOrder.EXTRA_NAMA, getIntent().getStringExtra(EXTRA_NAMA));
                pertaliteIintent.putExtra(LokasiOrder.EXTRA_EMAIL, getIntent().getStringExtra(EXTRA_EMAIL));
                pertaliteIintent.putExtra(LokasiOrder.EXTRA_ALAMAT, getIntent().getStringExtra(EXTRA_ALAMAT));
                pertaliteIintent.putExtra(LokasiOrder.EXTRA_ID_DOKUMEN, getIntent().getStringExtra(EXTRA_ID_DOKUMEN));
                pertaliteIintent.putExtra(LokasiOrder.EXTRA_NOHP, getIntent().getStringExtra(EXTRA_NOHP));
                pertaliteIintent.putExtra(LokasiOrder.EXTRA_JENIS_BENSIN, "Pertalite");
                startActivity(pertaliteIintent);
            }
        });

        kePesanPertamax.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent pertamaxIntent = new Intent(Dashboard.this, LokasiOrder.class);
                pertamaxIntent.putExtra(LokasiOrder.EXTRA_NAMA, getIntent().getStringExtra(EXTRA_NAMA));
                pertamaxIntent.putExtra(LokasiOrder.EXTRA_EMAIL, getIntent().getStringExtra(EXTRA_EMAIL));
                pertamaxIntent.putExtra(LokasiOrder.EXTRA_ALAMAT, getIntent().getStringExtra(EXTRA_ALAMAT));
                pertamaxIntent.putExtra(LokasiOrder.EXTRA_ID_DOKUMEN, getIntent().getStringExtra(EXTRA_ID_DOKUMEN));
                pertamaxIntent.putExtra(LokasiOrder.EXTRA_NOHP, getIntent().getStringExtra(EXTRA_NOHP));
                pertamaxIntent.putExtra(LokasiOrder.EXTRA_JENIS_BENSIN, "Pertamax");
                startActivity(pertamaxIntent);
            }
        });
    }

    public void tampilkanNama(){
        String nama = getIntent().getStringExtra(EXTRA_NAMA);
        if (nama==null){
            ojoLali.signOut();
            Intent intent = new Intent(Intent.ACTION_MAIN);
            intent.addCategory(Intent.CATEGORY_HOME);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
        haloOm.setText(String.format("Halo Kak %s", nama));
    }

    // blok kode untuk keluar dari aplikasi
    @Override
    public void onBackPressed() {
        AlertDialog.Builder builder1 = new AlertDialog.Builder(Dashboard.this);
        builder1.setMessage("Apakah kamu yakin ingin keluar sekarang disini juga?");
        builder1.setCancelable(false);
        builder1.setIcon(R.drawable.logodibensinan);
        builder1.setTitle("Warning!!!!");

        builder1.setPositiveButton(
                "Yes",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        ojoLali.signOut();
                        Intent intent = new Intent(Intent.ACTION_MAIN);
                        intent.addCategory(Intent.CATEGORY_HOME);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                        startActivity(intent);
                    }
                });

        builder1.setNegativeButton(
                "No",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        dialog.cancel();
                    }
                });

        AlertDialog alert11 = builder1.create();
        alert11.show();
    }

}