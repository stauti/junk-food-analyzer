package de.fh_rosenheim.myapplication;

import android.content.Context;
import android.widget.Toast;

import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;

import org.json.JSONObject;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;


public class DatabaseConnect {

    private static final String SERVER_URL = "http://openlibrary.org/search.json?q=";
    private static final String POST_URL = "http://posttestserver.com/post.php";
    private static final String PUT_URL = "http://141.60.38.18/m2m/public/devices/demo";
    private Context context;

    AsyncHttpClient client = new AsyncHttpClient();

    public DatabaseConnect(Context context){
        this.context = context;
    }

    public void get(String searchString) {
        Toast.makeText(context,"Updating...",Toast.LENGTH_SHORT).show();
        String urlString = "";

        try {
            urlString = URLEncoder.encode(searchString, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            Toast.makeText(context,"Error encoding",Toast.LENGTH_LONG).show();
            //Toast.makeText(this, "Error: " + e.getMessage(), Toast.LENGTH_LONG).show();
        }finally {
            //Toast.makeText(context,SERVER_URL + urlString,Toast.LENGTH_LONG).show();
        }
        client.get(SERVER_URL + urlString,
                new JsonHttpResponseHandler() {
                    @Override
                    public void onSuccess(int statusCode, org.apache.http.Header[] headers, org.json.JSONObject response){
                        //Toast.makeText(context,"Update successful!",Toast.LENGTH_LONG).show();
                    }
                    @Override
                    public void onFailure(int statusCode, org.apache.http.Header[] headers, java.lang.Throwable throwable, org.json.JSONObject errorResponse){
                        Toast.makeText(context,"Unable to update!",Toast.LENGTH_LONG).show();
                    }
                }
        );
    }
    public void post(JSONObject update) {
        Toast.makeText(context, "Updating server...", Toast.LENGTH_SHORT).show();
        RequestParams params = new RequestParams("single", update);
        client.post(POST_URL, params,
                new JsonHttpResponseHandler() {
                    @Override
                    public void onSuccess(int statusCode, org.apache.http.Header[] headers, org.json.JSONObject response) {
                        Toast.makeText(context, "Update successful!", Toast.LENGTH_LONG).show();
                    }

                    @Override
                    public void onFailure(int statusCode, org.apache.http.Header[] headers, java.lang.Throwable throwable, org.json.JSONObject errorResponse) {
                        Toast.makeText(context, "Unable to update!", Toast.LENGTH_LONG).show();
                    }
                }
        );
    }

    public void put(JSONObject update){
        Toast.makeText(context,"Updating server...",Toast.LENGTH_SHORT).show();
        RequestParams params = new RequestParams("single", BspJsonErzeuger.makeJsonObjectOn());
        client.put(context, POST_URL, params,
                new JsonHttpResponseHandler() {
                    @Override
                    public void onSuccess(int statusCode, org.apache.http.Header[] headers, org.json.JSONObject response) {
                        Toast.makeText(context, "Update successful!", Toast.LENGTH_LONG).show();
                    }

                    @Override
                    public void onFailure(int statusCode, org.apache.http.Header[] headers, java.lang.Throwable throwable, org.json.JSONObject errorResponse) {
                        Toast.makeText(context, "Unable to update!", Toast.LENGTH_LONG).show();
                    }
                }
        );
    }
}
