package com.iothon.logindibensinan;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.fragment.app.FragmentTransaction;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.location.Address;
import android.location.Geocoder;
import android.location.Location;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnSuccessListener;

import java.io.IOException;
import java.util.List;
import java.util.Locale;

public class LokasiOrder extends AppCompatActivity {

    Button kePesan;
    TextView namaBensin;
    FusedLocationProviderClient fusedLocationProviderClient;
    private static double lattitude,longitude;
    private static String address = "unknown", city , country = "unknown";
    public static final String EXTRA_NAMA = "extra_name";
    public static final String EXTRA_JENIS_BENSIN = "extra_jenis_bensin";
    public static final String EXTRA_ALAMAT = "extra_alamat";
    public static final String EXTRA_EMAIL = "extra_email";
    public static final String EXTRA_NOHP = "extra_noHP";
    public static final String EXTRA_ID_DOKUMEN = "extra_id_dokumen";
    private final static int REQUEST_CODE = 100;
    private FragmentTransaction fragmentTransaction;
    private Intent pesanBensin;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //transparant Statusbar
        requestWindowFeature(1); // baru
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS, // baru
                WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS); // baru
        getWindow().setStatusBarColor(Color.TRANSPARENT);// baru

        setContentView(R.layout.activity_lokasi_order);

        kePesan = findViewById(R.id.pesan_kasana);
        namaBensin = findViewById(R.id.namabensin);
        fragmentTransaction = getSupportFragmentManager().beginTransaction();
        fusedLocationProviderClient = LocationServices.getFusedLocationProviderClient(this);
        namaBensin.setText(getIntent().getStringExtra(EXTRA_JENIS_BENSIN));
        pesanBensin = new Intent(LokasiOrder.this, Pesan.class);

        getLastLocation();

        kePesan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                pesanBensin.putExtra(Pesan.EXTRA_NAMA, getIntent().getStringExtra(EXTRA_NAMA));
                pesanBensin.putExtra(Pesan.EXTRA_JENIS_BENSIN, getIntent().getStringExtra(EXTRA_JENIS_BENSIN));
                pesanBensin.putExtra(Pesan.EXTRA_EMAIL, getIntent().getStringExtra(EXTRA_EMAIL));
                pesanBensin.putExtra(Pesan.EXTRA_ALAMAT, getIntent().getStringExtra(EXTRA_ALAMAT));
                pesanBensin.putExtra(Pesan.EXTRA_ID_DOKUMEN, getIntent().getStringExtra(EXTRA_ID_DOKUMEN));
                pesanBensin.putExtra(Pesan.EXTRA_NOHP, getIntent().getStringExtra(EXTRA_NOHP));
                startActivity(pesanBensin);
            }
        });

    }
    @SuppressLint("MissingPermission")
    private void getLastLocation(){
        if (ContextCompat.checkSelfPermission(LokasiOrder.this, Manifest.permission.ACCESS_FINE_LOCATION) == PackageManager.PERMISSION_GRANTED){
            fusedLocationProviderClient.getLastLocation().addOnSuccessListener(new OnSuccessListener<Location>() {
                @Override
                public void onSuccess(Location location) {
                    if (location != null){
                        try {
                            Geocoder geocoder = new Geocoder(LokasiOrder.this, Locale.getDefault());
                            List<Address> addresses = geocoder.getFromLocation(location.getLatitude(), location.getLongitude(), 1);
                            lattitude = addresses.get(0).getLatitude();
                            longitude = addresses.get(0).getLongitude();
                            address = addresses.get(0).getAddressLine(0);
                            city = addresses.get(0).getLocality();
                            country = addresses.get(0).getCountryName();
                            MapsFragment petaFragment = new MapsFragment(lattitude, longitude, city);
                            fragmentTransaction.replace(R.id.isi_maps, petaFragment).commit();

                            pesanBensin.putExtra(Pesan.EXTRA_ALAMAT_PELANGGAN, address);
                            pesanBensin.putExtra(Pesan.EXTRA_LATITUDE, lattitude);
                            pesanBensin.putExtra(Pesan.EXTRA_LONGITUDE, longitude);
                            pesanBensin.putExtra(Pesan.EXTRA_CITY, city);

                        } catch (IOException e) {
                            e.printStackTrace();
                            Log.e("ERROR", e.getMessage());
                        }
                    }
                }
            });
        }else {
            askPermission();
        }
    }
    private void askPermission() {
        ActivityCompat.requestPermissions(LokasiOrder.this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION},REQUEST_CODE);
    }
    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull @org.jetbrains.annotations.NotNull String[] permissions, @NonNull @org.jetbrains.annotations.NotNull int[] grantResults) {
        if (requestCode == REQUEST_CODE){
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED){
                getLastLocation();
            }else {
                Toast.makeText(LokasiOrder.this,"Please provide the required permission",Toast.LENGTH_SHORT).show();
            }
        }
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
    }


}