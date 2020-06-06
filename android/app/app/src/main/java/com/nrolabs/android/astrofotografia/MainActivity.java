package com.nrolabs.android.astrofotografia;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.net.http.SslError;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.RequiresApi;
import android.view.KeyEvent;
import android.webkit.SslErrorHandler;
import android.webkit.WebResourceResponse;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.webkit.WebResourceRequest;
import android.webkit.WebResourceError;
import android.view.View;
import android.graphics.Bitmap;
import java.lang.String;
import android.support.v4.widget.SwipeRefreshLayout;

public class MainActivity extends Activity {

    private WebView WebViewUrl, WebViewError, WebViewProgress, WebViewRefresh;
    SwipeRefreshLayout swipe;

    private String Url      =   "https://nrolabs.com/android/astrofotografia/";
    private String Progress =   "file:///android_asset/progress.html";
    private String Refresh  =   "file:///android_asset/refresh.html";
    private String Error    =   "file:///android_asset/error.html";
    private String BackgroundColor  =   "#242629";

    @SuppressLint("SetJavaScriptEnabled")
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);

        WebViewProgress = findViewById(R.id.web_view_progress);
        WebViewUrl      = findViewById(R.id.web_view_url);
        WebViewRefresh  = findViewById(R.id.web_view_refresh);

        WebViewProgress.setBackgroundColor(Color.parseColor(BackgroundColor));
        WebViewUrl.setBackgroundColor(Color.parseColor(BackgroundColor));
        WebViewRefresh.setBackgroundColor(Color.parseColor(BackgroundColor));

        WebViewProgress.setVisibility(View.INVISIBLE);
        WebViewUrl.setVisibility(View.INVISIBLE);
        WebViewRefresh.setVisibility(View.INVISIBLE);

        WebViewProgress.loadUrl(Progress);

        swipe = (SwipeRefreshLayout)findViewById(R.id.swipe);

        swipe.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                WebViewRefreshAction();
            }
        });

        WebSettings webSettingsWebViewProgress = WebViewProgress.getSettings();
        webSettingsWebViewProgress.setJavaScriptEnabled(true);
        webSettingsWebViewProgress.setDomStorageEnabled(true);

        WebViewProgress.setWebViewClient(new WebViewClient(){
            @Override
            public void onPageFinished(WebView view, String url) {

                WebViewProgress.setVisibility(View.VISIBLE);

                WebViewRefresh.loadUrl(Refresh);

                WebSettings webSettingsWebViewRefresh = WebViewRefresh.getSettings();
                webSettingsWebViewRefresh.setJavaScriptEnabled(true);
                webSettingsWebViewRefresh.setDomStorageEnabled(true);

                WebViewRefresh.setWebViewClient(new WebViewClient(){
                    @Override
                    public void onPageFinished(WebView view, String url) {
                        WebViewUrlAction(Url);
                    }
                });
            }
        });
    }

    public void WebViewUrlAction(final String url){

        WebViewProgress = findViewById(R.id.web_view_progress);
        WebViewUrl      = findViewById(R.id.web_view_url);
        WebViewRefresh  = findViewById(R.id.web_view_refresh);

        WebViewProgress.setBackgroundColor(Color.parseColor(BackgroundColor));
        WebViewUrl.setBackgroundColor(Color.parseColor(BackgroundColor));
        WebViewRefresh.setBackgroundColor(Color.parseColor(BackgroundColor));

        WebViewUrl.loadUrl(url);

        WebSettings webSettingsWebViewUrl = WebViewUrl.getSettings();
        webSettingsWebViewUrl.setJavaScriptEnabled(true);
        webSettingsWebViewUrl.setDomStorageEnabled(true);

        WebViewUrl.setWebViewClient(new WebViewClient(){
            @Override
            public void onPageStarted(WebView view, String url, Bitmap favicon) {

                super.onPageStarted(view, url, favicon);

            }
            @Override
            public void onPageFinished(WebView view, String url) {

                swipe.setRefreshing(false);

                super.onPageFinished(view, url);

                WebViewProgress.setVisibility(View.INVISIBLE);
                WebViewRefresh.setVisibility(View.INVISIBLE);
                WebViewUrl.setVisibility(View.VISIBLE);

            }
            @Override
            public void onReceivedError(WebView view, WebResourceRequest request, WebResourceError error) {
                view.loadUrl(Error);
            }
            /*
            @Override
            public void onReceivedSslError(WebView view, SslErrorHandler handler, SslError error ) {
                view.loadUrl(Error);
            }

            @Override
            public void onReceivedHttpError(WebView view, WebResourceRequest request, WebResourceResponse errorResponse) {
                view.loadUrl(Error);
            }
*/
            @SuppressWarnings("deprecation")
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, String url) {
                if (url.contains(Url)) {
                    return false;
                } else {
                    WebViewUrlAction(url);
                    return true;
                }
            }

            @RequiresApi(Build.VERSION_CODES.N)
            @Override
            public boolean shouldOverrideUrlLoading(WebView view, WebResourceRequest request) {
                String url = request.getUrl().toString();
                if (url.contains(Url)) {
                    return false;
                } else {
                    WebViewUrlAction(url);
                    return true;
                }
            }
        });
    }

    public void WebViewRefreshAction(){

        WebViewProgress = findViewById(R.id.web_view_progress);
        WebViewUrl      = findViewById(R.id.web_view_url);
        WebViewRefresh  = findViewById(R.id.web_view_refresh);

        WebViewProgress.setBackgroundColor(Color.parseColor(BackgroundColor));
        WebViewUrl.setBackgroundColor(Color.parseColor(BackgroundColor));
        WebViewRefresh.setBackgroundColor(Color.parseColor(BackgroundColor));

        WebViewUrl.setVisibility(View.INVISIBLE);
        WebViewRefresh.setVisibility(View.VISIBLE);
        WebViewProgress.setVisibility(View.INVISIBLE);

        WebViewUrlAction(Url);
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
        if (keyCode == KeyEvent.KEYCODE_BACK && WebViewUrl.canGoBack()) {
            WebViewUrl.goBack();
            return true;
        } else {
            super.onBackPressed();
        }
        return super.onKeyDown(keyCode, event);
    }
}
