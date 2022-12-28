package com.iothon.logindibensinan;

import android.content.Context;
import android.location.Address;
import android.location.Geocoder;

import java.util.List;
import java.util.Locale;

public class MitraItem {
    private String namaMitra;
    private String emailMitra;
    private String jenisBensin;
    private double latitude;
    private double longitude;
    private String waMitra;
    private String stokPertalite;
    private String stokPertamax;

    // dibuat untuk memenuhi permintaan, bukan merupakan parameter yang dibutuhkan
    private String panggenan;

    public MitraItem(String namaMitra,
                     String emailMitra,
                     String jenisBensin,
                     String panggenan,
                     String stokPertalite,
                     String stokPertamax) {

        this.namaMitra = namaMitra;
        this.emailMitra = emailMitra;
        this.jenisBensin = jenisBensin;
        this.waMitra = waMitra;
        this.panggenan = panggenan;
        this.stokPertalite = stokPertalite;
        this.stokPertamax = stokPertamax;
    }

    public String getNamaMitra() {
        return namaMitra;
    }

    public void setNamaMitra(String namaMitra) {
        this.namaMitra = namaMitra;
    }

    public String getEmailMitra() {
        return emailMitra;
    }

    public void setEmailMitra(String emailMitra) {
        this.emailMitra = emailMitra;
    }

    public String getJenisBensin() {
        return jenisBensin;
    }

    public void setJenisBensin(String jenisBensin) {
        this.jenisBensin = jenisBensin;
    }

    public double getLatitude() {
        return latitude;
    }

    public void setLatitude(double latitude) {
        this.latitude = latitude;
    }

    public double getLongitude() {
        return longitude;
    }

    public void setLongitude(double longitude) {
        this.longitude = longitude;
    }

    public String getWaMitra() {
        return waMitra;
    }

    public void setWaMitra(String waMitra) {
        this.waMitra = waMitra;
    }

    public String getStokPertalite() {
        return stokPertalite;
    }

    public void setStokPertalite(String stokPertalite) {
        this.stokPertalite = stokPertalite;
    }

    public String getStokPertamax() {
        return stokPertamax;
    }

    public void setStokPertamax(String stokPertamax) {
        this.stokPertamax = stokPertamax;
    }

    public String getPanggenan() {
        return panggenan;
    }

    public void setPanggenan(String panggenan) {
        this.panggenan = panggenan;
    }
}
