package project.jakkit.restaurant;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.os.Build;
import android.os.StrictMode;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.view.WindowManager;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.sql.Connection;
import java.sql.Statement;
import java.text.SimpleDateFormat;

import android.content.Intent;
import android.widget.Toast;

/**
 * Created by KHAMMA on 11/05/2017.
 */

public class OrderActivity extends ActionBarActivity {

    private FoodTABLE objFoodTABLE;
    private ListView myListView;
    private TextView txtShowTable, txtShowOfficer;
    private String strOfficer, strTable, strFood, strAmount, strHotLevel, strPrice, strNumFood, strUserID, strDate;

    private int intListO=1;

    ConnectionClass connectionClass;
    ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_order);

        bindWidget();

        connectionClass = new ConnectionClass();
        progressDialog = new ProgressDialog(OrderActivity.this);
        objFoodTABLE = new FoodTABLE(this);

        showTable();
        showOfficer();
        getOfficerID();
        getDate();
        showDate();

        //Synchronize JSON to SQLite
        synJSONtoSQLite();

        //Create ListView
        createListView();

        synJSONgetListOrder();

    }   // onCreate
    private void bindWidget() {
        myListView = (ListView)findViewById(R.id.listView);
        txtShowTable = (TextView)findViewById(R.id.txtShowTable);
        txtShowOfficer = (TextView) findViewById(R.id.txtShowOfficer);
    }
    private void showTable(){
        strTable = getIntent().getExtras().getString("Table");
        txtShowTable.setText(strTable);
    }
    private void showOfficer() {
        strOfficer = getIntent().getExtras().getString("Officer");
        txtShowOfficer.setText(strOfficer);
    }
    private void getOfficerID() {
        strUserID = getIntent().getExtras().getString("IDofficer");
    }
    private void showDate() {
        Thread t = new Thread() {
            @Override
            public void run() {
                try {
                    while (!isInterrupted()) {
                        Thread.sleep(1000);
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                TextView time = (TextView) findViewById(R.id.txtShowDateTime);
                                long date = System.currentTimeMillis();
                                SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                                String dateString = sdf.format(date);
                                time.setText(dateString);
                            }
                        });
                    }
                } catch (InterruptedException e) {
                }
            }
        };
        t.start();
    }
    private void getDate() {
        Thread t = new Thread() {
            @Override
            public void run() {
                try {
                    while (!isInterrupted()) {
                        Thread.sleep(1000);
                        runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                long date = System.currentTimeMillis();
                                SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd");
                                strDate = sdf.format(date);
                            }
                        });
                    }
                } catch (InterruptedException e) {
                }
            }
        };
        t.start();
    }
    private void createListView() {
        final String[] strListNumFood = objFoodTABLE.readAllNumFood();
        final String[] strListFood = objFoodTABLE.readAllFood();
        final String[] strListPrice = objFoodTABLE.readAllPrice();

        MyAdapter objMyAdapter = new MyAdapter(OrderActivity.this, strListFood, strListPrice, strListNumFood);
        myListView.setAdapter(objMyAdapter);

        //Click Active
        myListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

                strFood = strListFood[position];
                strPrice = strListPrice[position];
                strNumFood = strListNumFood[position];

                chooseItem();

            }   // event
        });

    }   // createListView
    private void chooseItem() {
        CharSequence[] charItem = {"1 จาน", "2 จาน", "3 จาน", "3 จาน", "5 จาน",};

        AlertDialog.Builder objBuilder = new AlertDialog.Builder(this);
        objBuilder.setIcon(R.drawable.food_order);
        objBuilder.setTitle("เลือกจำนวน");
        objBuilder.setCancelable(false);
        objBuilder.setSingleChoiceItems(charItem, -1, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {

                switch (which) {

                    case 0:
                        strAmount = "1";
                        break;
                    case 1:
                        strAmount = "2";
                        break;
                    case 2:
                        strAmount = "3";
                        break;
                    case 3:
                        strAmount = "4";
                        break;
                    case 4:
                        strAmount = "5";
                        break;

                }   // switch
                dialog.dismiss();

                chooseHotLevel();
            }   // event
        });
        objBuilder.setPositiveButton("ยกเลิก", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });

        AlertDialog objAlertDialog = objBuilder.create();
        objAlertDialog.show();

    }   // chooseItem
    private void chooseHotLevel() {
        CharSequence[] charItem = {"เผ็ดน้อย", "เผ็ดปานกลาง", "เผ็ดมาก",};

        AlertDialog.Builder objBuilder = new AlertDialog.Builder(this);
        objBuilder.setIcon(R.drawable.hot);
        objBuilder.setTitle("เลือกระดับความเผ็ด");
        objBuilder.setCancelable(false);
        objBuilder.setSingleChoiceItems(charItem, -1, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {

                switch (which) {
                    case 0:
                        strHotLevel = "1";
                        break;
                    case 1:
                        strHotLevel = "2";
                        break;
                    case 2:
                        strHotLevel = "3";
                        break;
                }   // switch

                dialog.dismiss();

                //Confirm Order
                confirmOrder();
            }   // event
        });
        AlertDialog objAlertDialog = objBuilder.create();
        objAlertDialog.show();
    }   // chooseItem

    private void confirmOrder() {

        AlertDialog.Builder objBuilder = new AlertDialog.Builder(this);
        objBuilder.setIcon(R.drawable.restaurant2);
        objBuilder.setTitle("ตรวจสอบรายการที่สั่ง");
        objBuilder.setCancelable(false);
        objBuilder.setMessage(strOfficer + "\n" + "โต๊ะ : "+ strTable+ "\n" + "อาหาร : "+ strFood +"\n" + "ราคา : "+ strPrice+ "\n" +"จำนวน : " + strAmount+ "\n" + "ระดับความเผ็ด : " + strHotLevel);
        objBuilder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                onPreExecute();
                upOrderToMySQL();

                dialog.dismiss();
            }
        });
        objBuilder.setNegativeButton("NO", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
            }
        });
        objBuilder.show();
    }   // confirmOrder

    public String upOrderToMySQL() {
            String z="";
            boolean isSuccess=false;

            try {
                Connection con = connectionClass.CONN();
                if (con == null) {
                    z = "Please check internet connection";
                } else {

                    String query = "insert into data_listorder values('" + intListO + "','" + strNumFood + "','" + strAmount + "','" + strHotLevel + "')";
                    String query2 = "insert into data_order values(NULL,'" + strTable + "','" + intListO + "','" + strDate + "','" + strUserID + "',' 1 ',' 1 ')";

                    Statement stmt = con.createStatement();
                    stmt.executeUpdate(query);
                    stmt.executeUpdate(query2);

                    Toast.makeText(getApplicationContext(), "บันทึกเรียบร้อย", Toast.LENGTH_SHORT).show();

                    intListO++;

                    z = "insert into successfull";
                    isSuccess = true;
                }
            } catch (Exception ex) {
                isSuccess = false;
                z = "Exceptions" + ex;
            }
            return z;
    }
    protected void onPreExecute() {
        progressDialog.setMessage("Loading...");
        progressDialog.show();
    }
    private void synJSONtoSQLite() {
        //Setup New Policy
        if (Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy objPolicy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(objPolicy);
        }
        //Create InputStream
        InputStream objInputStream = null;
        String strJSON = "";
        try {
            HttpClient objHttpClient = new DefaultHttpClient();
            HttpPost objHttpPost = new HttpPost("http://192.168.1.90/connect_food.php");
            HttpResponse objHttpResponse = objHttpClient.execute(objHttpPost);
            HttpEntity objHttpEntity = objHttpResponse.getEntity();
            objInputStream = objHttpEntity.getContent();

        } catch (Exception e) {
            Log.d("oic", "InputStream ==> " + e.toString());
        }
        //Create strJSON
        try {
            BufferedReader objBufferedReader = new BufferedReader(new InputStreamReader(objInputStream, "UTF-8"));
            StringBuilder objStringBuilder = new StringBuilder();
            String strLine = null;

            while ((strLine = objBufferedReader.readLine()) != null) {
                objStringBuilder.append(strLine);
            }   // while

            objInputStream.close();
            strJSON = objStringBuilder.toString();
        } catch (Exception e) {
            Log.d("oic", "strJSON ==> " + e.toString());
        }
        //UpData SQLite
        try {
            final JSONArray objJsonArray = new JSONArray(strJSON);
            for (int i = 0; i < objJsonArray.length(); i++) {

                JSONObject objJSONObject = objJsonArray.getJSONObject(i);

                String strNumFood = objJSONObject.getString("food_id");
                String strFood = objJSONObject.getString("food_name");
                Integer intPrice = objJSONObject.getInt("food_price");

                long addValue = objFoodTABLE.addValueToFood(strFood, intPrice, strNumFood);
            }
        } catch (Exception e) {
            Log.d("oic", "Update ==> " + e.toString());
        }
    }   // synJSONtoSQLite

    private void synJSONgetListOrder() {
        //Setup New Policy
        if (Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy objPolicy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(objPolicy);
        }
        //Create InputStream
        InputStream objInputStream = null;
        String strJSON = "";
        try {

            HttpClient objHttpClient = new DefaultHttpClient();
            HttpPost objHttpPost = new HttpPost("http://192.168.1.90/get_list_order.php");
            HttpResponse objHttpResponse = objHttpClient.execute(objHttpPost);
            HttpEntity objHttpEntity = objHttpResponse.getEntity();
            objInputStream = objHttpEntity.getContent();

        } catch (Exception e) {
            Log.d("oic", "InputStream ==> " + e.toString());
        }
        //Create strJSON
        try {
            BufferedReader objBufferedReader = new BufferedReader(new InputStreamReader(objInputStream, "UTF-8"));
            StringBuilder objStringBuilder = new StringBuilder();
            String strLine = null;
            while ((strLine = objBufferedReader.readLine()) != null) {
                objStringBuilder.append(strLine);
            }   // while
            objInputStream.close();
            strJSON = objStringBuilder.toString();

        } catch (Exception e) {
            Log.d("oic", "strJSON ==> " + e.toString());
        }
        //UpData SQLite
        try {
            final JSONArray objJsonArray = new JSONArray(strJSON);
            for (int j = 0; j < objJsonArray.length(); j++) {
                JSONObject objJSONObject = objJsonArray.getJSONObject(j);
                String strListOrder = objJSONObject.getString("listO_id");
                String strFoodID = objJSONObject.getString("food_id");
                Integer intAmount = objJSONObject.getInt("listO_amount");
                String strHot = objJSONObject.getString("listO_hot");

                intListO++;
            }
        } catch (Exception e) {
            Log.d("oic", "Update ==> " + e.toString());
        }
    }
    public void clicklogout(View view){
        Intent intent = new Intent(OrderActivity.this, MainActivity.class);
        startActivity(intent);
    }
    public void clickListOrder(View view){
        Intent intent = new Intent(OrderActivity.this, ListOrderActivity.class);
        intent.putExtra("Officer", strOfficer);
        intent.putExtra("IDofficer", strUserID);
        intent.putExtra("Table", strTable);
        startActivity(intent);
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_order, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}   // Main Class
