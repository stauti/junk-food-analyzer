package de.fh_rosenheim.myapplication;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ImageButton;
import android.widget.ListView;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;


public class ZeitsteuerungActivity extends AppCompatActivity implements View.OnClickListener {

    ImageButton okButton;
    ImageButton cancelButton;
    JSONObject device;
    ArrayList<String> list = new ArrayList<String>();
    MyCustomAdapter adapter;
    ListView lView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_zeitsteuerung);
        Intent intent = getIntent();
        String jsonObjectString = intent.getStringExtra("jsonObject");
        //Toast.makeText(this, jsonObjectString, Toast.LENGTH_LONG).show();
        try {
            device = new JSONObject(jsonObjectString);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        //hiding default app icon
        ActionBar actionBar = getSupportActionBar();
        actionBar.setDisplayShowCustomEnabled(false);

        //displaying custom ActionBar
        View mActionBarView = getLayoutInflater().inflate(R.layout.custom_imageview, null);
        actionBar.setCustomView(mActionBarView);
        actionBar.setDisplayOptions(ActionBar.DISPLAY_SHOW_CUSTOM);


        cancelButton = (ImageButton) findViewById(R.id.zeit_cancel);
        cancelButton.setOnClickListener(this);

        okButton = (ImageButton) findViewById(R.id.zeit_ok);
        okButton.setOnClickListener(this);

        //generate list

        list.add("8 Uhr Schaltstatus");
        list.add("8-ausschalten");
        list.add("12-einschalten");
        list.add("12-aus");
        list.add("18-einschalten");
        list.add("18-aus");

        //instantiate custom adapter
        adapter = new MyCustomAdapter(list, this);

        //handle listview and assign adapter
        lView = (ListView)findViewById(R.id.zeit_listview);
        lView.setAdapter(adapter);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.menu_home:
                Intent intent = new Intent(this, MainActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                return true;
            case R.id.menu_hinzu:
                intent = new Intent(this, GeraetHinzufuegenActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                return true;
            case R.id.menu_logout:
                intent = new Intent(this, MainActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public void onClick(View v) {
        switch (v.getId()){
            case R.id.zeit_cancel:{
                Intent zuMainWechselnCancel = new Intent(ZeitsteuerungActivity.this, MainActivity.class);
                zuMainWechselnCancel.putExtra("string", true);
                ZeitsteuerungActivity.this.startActivity(zuMainWechselnCancel);
                break;}
            case R.id.zeit_ok:{
                Intent zuMainWechselnCancel = new Intent(ZeitsteuerungActivity.this, MainActivity.class);
                zuMainWechselnCancel.putExtra("string", true);
                ZeitsteuerungActivity.this.startActivity(zuMainWechselnCancel);
                break;}
            default:
                break;
        }
    }
}
