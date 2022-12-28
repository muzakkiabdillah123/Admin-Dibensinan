package com.iothon.logindibensinan;

import static android.content.ContentValues.TAG;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.AuthResult;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.google.firebase.firestore.FirebaseFirestore;
import com.google.firebase.firestore.Query;
import com.google.firebase.firestore.QueryDocumentSnapshot;
import com.google.firebase.firestore.QuerySnapshot;

import java.util.Objects;

public class MainActivity extends AppCompatActivity {

    TextView tvRegister;
    Button btnLogin;

    private FirebaseAuth ojoLali;
    private EditText rxEmail, rxPassword;
    private int backButtonCount = 0;
    FirebaseFirestore db;

    private String namaku, peranku, emailku, alamatku, idDokumenku, nomorKu;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        //transparant Statusbar
        requestWindowFeature(1); // baru
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS, // baru
                WindowManager.LayoutParams.FLAG_LAYOUT_NO_LIMITS); // baru
        getWindow().setStatusBarColor(Color.TRANSPARENT);// baru

        setContentView(R.layout.activity_main);

        btnLogin = (Button) findViewById(R.id.btnLogin);
        ojoLali = FirebaseAuth.getInstance();
        rxEmail = findViewById(R.id.rx_email);
        rxPassword = findViewById(R.id.rx_password);
        tvRegister = (TextView) findViewById(R.id.tvRegister);
        db = FirebaseFirestore.getInstance();

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                loginPengguna();
            }
        });

        tvRegister.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                BukaRegister();
            }
        });
    }

    public void queryDataUser(){
        Query namaBerjaya = db.collection("penggunaHokya");
        namaBerjaya.get()
                .addOnCompleteListener(new OnCompleteListener<QuerySnapshot>() {
                    @Override
                    public void onComplete(@NonNull Task<QuerySnapshot> task) {
                        if (task.isSuccessful()) {
                            for (QueryDocumentSnapshot document : task.getResult()) {
                                if (Objects.requireNonNull(document.getData().get("email")).toString().equals(rxEmail.getText().toString())){
                                    namaku = Objects.requireNonNull(document.getData().get("nama")).toString();
                                    peranku = Objects.requireNonNull(document.getData().get("peran")).toString();
                                    emailku = Objects.requireNonNull(document.getData().get("email")).toString();
                                    alamatku = Objects.requireNonNull(document.getData().get("alamat")).toString();
                                    nomorKu = Objects.requireNonNull(document.getData().get("noHp").toString());
                                    idDokumenku = Objects.requireNonNull(document.getId());
                                }
                            }
                            if (peranku.equals("user")){
                                Toast.makeText(MainActivity.this, "Pengguna berhasil login dengan aman", Toast.LENGTH_SHORT).show();
                                Intent paketDashboard = new Intent(MainActivity.this, Dashboard.class);
                                paketDashboard.putExtra(Dashboard.EXTRA_NAMA, namaku);
                                paketDashboard.putExtra(Dashboard.EXTRA_EMAIL, emailku);
                                paketDashboard.putExtra(Dashboard.EXTRA_ALAMAT, alamatku);
                                paketDashboard.putExtra(Dashboard.EXTRA_ID_DOKUMEN, idDokumenku);
                                paketDashboard.putExtra(Dashboard.EXTRA_NOHP, nomorKu);
                                startActivity(paketDashboard);
                            } else {
                                ojoLali.signOut();
                                Toast.makeText(MainActivity.this, "Kamu Siapa?", Toast.LENGTH_SHORT).show();
                            }
                        } else {
                            Log.d(TAG, "Error getting documents: ", task.getException());
                        }
                    }
                });
    }

    public void BukaRegister(){
        Intent BukaActRegister = new Intent(getApplicationContext(),Register.class);
        startActivity(BukaActRegister);
    }

    @Override
    protected void onStart() {
        super.onStart();
        FirebaseUser currentUser = ojoLali.getCurrentUser();
        if(currentUser != null){
            Intent userNgeliyo = new Intent(MainActivity.this, Dashboard.class);
            userNgeliyo.putExtra(Dashboard.EXTRA_NAMA, namaku);
            userNgeliyo.putExtra(Dashboard.EXTRA_EMAIL, emailku);
            userNgeliyo.putExtra(Dashboard.EXTRA_ALAMAT, alamatku);
            userNgeliyo.putExtra(Dashboard.EXTRA_ID_DOKUMEN, idDokumenku);
            userNgeliyo.putExtra(Dashboard.EXTRA_NOHP, nomorKu);
            startActivity(userNgeliyo);
        }
    }

    private void loginPengguna(){
        String email = rxEmail.getText().toString();
        String password = rxPassword.getText().toString();
        if(TextUtils.isEmpty(email)){
            rxEmail.setError("Email nya diisi dulu mas/mbak");
            rxEmail.requestFocus();
        } else if(TextUtils.isEmpty(password)){
            rxPassword.setError("Password nya jangan lupa mas/mbak");
            rxPassword.requestFocus();
        } else {
            ojoLali.signInWithEmailAndPassword(email, password).addOnCompleteListener(new OnCompleteListener<AuthResult>() {
                @Override
                public void onComplete(@NonNull Task<AuthResult> task) {
                    if (task.isSuccessful()){
                        // pengguna yang login harus memiliki peran user
                        queryDataUser();
                    } else {
                        Toast.makeText(MainActivity.this, "Pengguna gagal login karena " + task.getException().getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
            });
        }
    }

    // blok kode untuk keluar dari aplikasi
    @Override
    public void onBackPressed() {
        if(backButtonCount >= 1)
        {
            Intent intent = new Intent(Intent.ACTION_MAIN);
            intent.addCategory(Intent.CATEGORY_HOME);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        } else {
            Toast.makeText(this, "Tekan tombol kembali sekali lagi untuk keluar dari aplikasi", Toast.LENGTH_SHORT).show();
            backButtonCount++;
        }
    }

}