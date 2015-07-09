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

import org.json.JSONObject;


public class GeraetHinzufuegenActivity extends ActionBarActivity implements View.OnClickListener {

    ImageButton okButton;
    ImageButton cancelButton;
    EditText name;
    EditText nummer;
    EditText sonstige;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_geraet_hinzufuegen);
        Intent intent = getIntent();
        //String value = intent.getStringExtra("string");

        ActionBar actionBar = getSupportActionBar();
        actionBar.setDisplayShowCustomEnabled(false);
        //displaying custom ActionBar
        View mActionBarView = getLayoutInflater().inflate(R.layout.custom_imageview, null);
        actionBar.setCustomView(mActionBarView);
        actionBar.setDisplayOptions(ActionBar.DISPLAY_SHOW_CUSTOM);

        cancelButton = (ImageButton) findViewById(R.id.hinzufuegen_cancel);
        cancelButton.setOnClickListener(this);

        okButton = (ImageButton) findViewById(R.id.hinzufuegen_ok);
        okButton.setOnClickListener(this);

        name = (EditText) findViewById(R.id.hinzufuegen_name);
        nummer = (EditText) findViewById(R.id.hinzufuegen_nummer);
        sonstige = (EditText) findViewById(R.id.hinzufuegen_sonstiges);
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
            case R.id.hinzufuegen_cancel:{
                Intent zuMainWechselnCancel = new Intent(GeraetHinzufuegenActivity.this, MainActivity.class);
                zuMainWechselnCancel.putExtra("string", true);
                GeraetHinzufuegenActivity.this.startActivity(zuMainWechselnCancel);
                break;}
            case R.id.hinzufuegen_ok:{
                DatabaseConnect db = new DatabaseConnect(this);
                db.post(new JSONObject());
                Intent zuMainWechselnCancel = new Intent(GeraetHinzufuegenActivity.this, MainActivity.class);
                String input = name.getText().toString();
                zuMainWechselnCancel.putExtra("string", true);
                GeraetHinzufuegenActivity.this.startActivity(zuMainWechselnCancel);
                break;}
            default:
                break;
        }
    }
}
