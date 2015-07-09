package de.fh_rosenheim.myapplication;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBar;
import android.support.v7.app.ActionBarActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;

import org.json.JSONException;
import org.json.JSONObject;


public class GeraetAendernActivity extends ActionBarActivity implements View.OnClickListener {

    ImageButton okButton;
    ImageButton cancelButton;
    ImageButton deleteButton;
    EditText name, sim, id;
    JSONObject device;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_geraet_aendern);
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

        name = (EditText) findViewById(R.id.aendern_name);
        name.setText(device.optString("name"));
        sim = (EditText) findViewById(R.id.aendern_nummer);
        sim.setText(device.optString("sim"));
        id = (EditText) findViewById(R.id.aendern_sonstiges);
        id.setText(device.optString("id"));

        cancelButton = (ImageButton) findViewById(R.id.aendern_cancel);
        cancelButton.setOnClickListener(this);

        okButton = (ImageButton) findViewById(R.id.aendern_ok);
        okButton.setOnClickListener(this);

        deleteButton = (ImageButton) findViewById(R.id.aendern_loeschen);
        deleteButton.setOnClickListener(this);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
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
            case R.id.aendern_cancel:{
                Intent zuMainWechselnCancel = new Intent(GeraetAendernActivity.this, MainActivity.class);
                //zuMainWechselnCancel.putExtra("string", true);
                GeraetAendernActivity.this.startActivity(zuMainWechselnCancel);
                break;}
            case R.id.aendern_ok: {
                try {
                    device.put("name", name.getText().toString());
                    device.put("sim", sim.getText().toString());
                    device.put("id", id.getText().toString());
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                    DatabaseConnect db = new DatabaseConnect(this);
                    db.post(device);
                    Intent zuMainWechselnCancel = new Intent(GeraetAendernActivity.this, MainActivity.class);
                    //zuMainWechselnCancel.putExtra("string", true);
                    GeraetAendernActivity.this.startActivity(zuMainWechselnCancel);
                    break;}
                case R.id.aendern_loeschen: {
                    //geraet loeschen TODO
                    Intent zuMainWechseln = new Intent(GeraetAendernActivity.this, MainActivity.class);
                    zuMainWechseln.putExtra("string", true);
                    GeraetAendernActivity.this.startActivity(zuMainWechseln);
                    break;
                }
                default:
                    break;
            }
        }
    }

