package de.fh_rosenheim.myapplication;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBar;
import android.support.v7.app.AppCompatActivity;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


public class MainActivity extends AppCompatActivity implements View.OnClickListener {

    TextView mainTextView;
    ImageButton goToGeraetHinzufuegenButton;
    ListView mainListView;
    MyCustomAdapterMain mArrayAdapter;
    JSONArray jsonArray = new JSONArray();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Intent intent = getIntent();
        //String value = intent.getStringExtra("string");

        //hiding default app icon
        ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            actionBar.setDisplayShowCustomEnabled(false);
        }
        //displaying custom ActionBar
        View mActionBarView = getLayoutInflater().inflate(R.layout.custom_imageview, null);
        if (actionBar != null) {
            actionBar.setCustomView(mActionBarView);
            actionBar.setDisplayOptions(ActionBar.DISPLAY_SHOW_CUSTOM);
        }

        //Hier muss noch die korrekte URL zum aktualisieren der Geraeteliste
        // eingetragen werden. Erwartet wird unten ein JSONArray.
        DatabaseConnect db = new DatabaseConnect(this);
        db.get("hunger+games+suzanne+collins");
        //Bis dahin wird folgendes Bsp verwendet:
        jsonArray = BspJsonErzeuger.makeJsonArray();

        goToGeraetHinzufuegenButton = (ImageButton) findViewById(R.id.hinzu_button);
        goToGeraetHinzufuegenButton.setOnClickListener(this);

        mainListView = (ListView) findViewById(R.id.main_listview);
        mArrayAdapter = new MyCustomAdapterMain(jsonArray, this);
        mainListView.setAdapter(mArrayAdapter);
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
            case R.id.hinzu_button:
                Intent zuHinzuWechseln = new Intent(MainActivity.this, GeraetHinzufuegenActivity.class);
                zuHinzuWechseln.putExtra("string", true);
                MainActivity.this.startActivity(zuHinzuWechseln);
                break;
            default:
                break;
        }
    }

    ///////////////
    public class MyCustomAdapterMain extends BaseAdapter implements ListAdapter {

        private JSONArray jsonArray;
        private Context context;

        public MyCustomAdapterMain(JSONArray jsonArray, Context context) {
            assert context != null;
            assert jsonArray != null;
            this.jsonArray = jsonArray;
            this.context = context;
        }

        @Override
        public int getCount() {
            return jsonArray.length();
        }

        @Override
        public JSONObject getItem(int pos) {
            return jsonArray.optJSONObject(pos);
        }

        @Override
        public long getItemId(int pos) {
            JSONObject jsonObject = getItem(pos);
            return jsonObject.optLong("id");
        }

        @Override
        public View getView(final int position, View convertView, ViewGroup parent) {
            View view = convertView;
            if (view == null) {
                LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                view = inflater.inflate(R.layout.list_element_main, null);
            }

            //Textview aufbauen und mit String aus JSON fuellen
            TextView listItemText = (TextView)view.findViewById(R.id.list_item_string);
            listItemText.setText(getItem(position).optString("name"));
            listItemText.setTag(position);

            //Buttons hinzufuegen und Positions-Tag bereitstellen
            ImageButton zeitButton = (ImageButton)view.findViewById(R.id.list_zeit_button);
            ImageButton aendernButton = (ImageButton)view.findViewById(R.id.list_aendern_button);
            final ImageButton toggleButton = (ImageButton)view.findViewById(R.id.list_toggle_button);
            zeitButton.setTag(position);
            aendernButton.setTag(position);
            toggleButton.setTag(position);

            //Status der Geraete (laut Server) in der Liste setzen:
            if(getItem(position).optString("status").equals("true")) {
                toggleButton.setBackground(getResources().getDrawable(R.drawable.light_bulb_257));
            }
            else
            {
                toggleButton.setBackground(getResources().getDrawable(R.drawable.light_bulb_256));
            }

            zeitButton.setOnClickListener(new View.OnClickListener(){
                @Override
                public void onClick(View v) {
                    int position = (int)v.getTag();
                    JSONObject device = new JSONObject();
                    try {
                        device = jsonArray.getJSONObject(position);
                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(context, "Problem retrieving device.", Toast.LENGTH_LONG).show();
                    }
                    Intent zuZeitWechseln = new Intent(MainActivity.this, ZeitsteuerungActivity.class);
                    zuZeitWechseln.putExtra("jsonObject", device.toString());
                    MainActivity.this.startActivity(zuZeitWechseln);
                }
            });

            aendernButton.setOnClickListener(new View.OnClickListener(){
                @Override
                public void onClick(View v) {
                    int position = (int)v.getTag();
                    JSONObject device = new JSONObject();
                    try {
                        device = jsonArray.getJSONObject(position);
                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(context, "Problem retrieving device.", Toast.LENGTH_LONG).show();
                    }
                    Intent zuAendernWechseln = new Intent(MainActivity.this, GeraetAendernActivity.class);
                    zuAendernWechseln.putExtra("jsonObject", device.toString());
                    //Toast.makeText(context, device.toString(), Toast.LENGTH_LONG).show();
                    MainActivity.this.startActivity(zuAendernWechseln);
                }
            });

            toggleButton.setOnClickListener(new View.OnClickListener(){
                @Override
                public void onClick(View v) {
                    int position = (int)v.getTag();
                    JSONObject device = new JSONObject();
                    try {
                        device = jsonArray.getJSONObject(position);
                    } catch (JSONException e) {
                        e.printStackTrace();
                        Toast.makeText(context, "Problem retrieving device.", Toast.LENGTH_LONG).show();
                    }

                    if(device.optString("status").equals("false")) {
                        DatabaseConnect db = new DatabaseConnect(context);
                        try {
                            device.put("status", true);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        db.post(device);
                        toggleButton.setBackground(getResources().getDrawable(R.drawable.light_bulb_257));
                    }
                    else
                    {
                        DatabaseConnect db = new DatabaseConnect(context);
                        try {
                            device.put("status", false);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                        db.post(device);
                        toggleButton.setBackground(getResources().getDrawable(R.drawable.light_bulb_256));
                    }
                }
            });

            return view;
        }
    }
}
