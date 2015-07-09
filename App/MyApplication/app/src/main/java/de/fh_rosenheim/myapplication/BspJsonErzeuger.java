package de.fh_rosenheim.myapplication;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class BspJsonErzeuger {

    public static JSONArray makeJsonArray() {

        /////////
        //Solange noch keine JSONs vom Server kommen, wird zum Testen
        // folgendes JSONArray verwendet:

        JSONArray jsonArray = new JSONArray();
        JSONObject geraet1 = new JSONObject();
        try {
            geraet1.put("id", "1");
            geraet1.put("name", "Lampe 1");
            geraet1.put("sim", "1234567890");
            geraet1.put("status", "true");
            geraet1.put("timecontrol1", "06:00:00");
            geraet1.put("timecontrol2", "12:00:00");
            geraet1.put("timecontrol3", "18:00:00");

        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }

        JSONObject geraet2 = new JSONObject();
        try {
            geraet2.put("id", "2");
            geraet2.put("name", "Lampe 2");
            geraet2.put("sim", "2223334445");
            geraet2.put("status", "true");
            geraet2.put("timecontrol1", "06:00:00");
            geraet2.put("timecontrol2", "12:00:00");
            geraet2.put("timecontrol3", "18:00:00");

        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }

        JSONObject geraet3 = new JSONObject();
        try {
            geraet3.put("id", "3");
            geraet3.put("name", "Lampe 3");
            geraet3.put("sim", "3334445556");
            geraet3.put("status", "false");
            geraet3.put("timecontrol1", "06:00:00");
            geraet3.put("timecontrol2", "12:00:00");
            geraet3.put("timecontrol3", "18:00:00");

        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }

        JSONObject geraet4 = new JSONObject();
        try {
            geraet4.put("id", "4");
            geraet4.put("name", "Lampe 4");
            geraet4.put("sim", "4445556667");
            geraet4.put("status", "false");
            geraet4.put("timecontrol1", "06:00:00");
            geraet4.put("timecontrol2", "12:00:00");
            geraet4.put("timecontrol3", "18:00:00");

        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }

        JSONObject geraet5 = new JSONObject();
        try {
            geraet5.put("id", "5");
            geraet5.put("name", "Lampe 5");
            geraet5.put("sim", "5556667778");
            geraet5.put("status", "false");
            geraet5.put("timecontrol1", "06:00:00");
            geraet5.put("timecontrol2", "12:00:00");
            geraet5.put("timecontrol3", "18:00:00");

        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }

        jsonArray.put(geraet1);
        jsonArray.put(geraet2);
        jsonArray.put(geraet3);
        jsonArray.put(geraet4);
        jsonArray.put(geraet5);

        return jsonArray;
    }

    public static JSONObject makeJsonObjectOn() {

        /////////
        //Solange noch keine JSONs vom Server kommen, wird zum Testen
        // folgendes JSONArray verwendet:

        JSONObject geraet1 = new JSONObject();
        try {
            geraet1.put("phonenumber", "00491705089577");
            geraet1.put("status", "true");
        } catch (JSONException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
        return geraet1;
    }
}
