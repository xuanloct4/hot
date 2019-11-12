/*
 * Copyright (c) 2015, Majenko Technologies
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice, this
 *   list of conditions and the following disclaimer in the documentation and/or
 *   other materials provided with the distribution.
 *
 * * Neither the name of Majenko Technologies nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/* Create a WiFi access point and provide a web server on it. */

#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFiMulti.h>
#include <SimpleTimer.h>
//#include <ArduinoJson.h>
#include "RestAPI.h"
#include "JSONUtils.h"
#include "SPIFFSUtils.h"

//// Utils
StringUtil stringUtil;
JSONUtils jsonUtils;
SPIFFSUtils spiffsUtils;
RestAPI restAPI;
SimpleTimer timer;
WiFiClientSecure httpsClient;
ESP8266WebServer server(80);
//ESP8266WiFiMulti WiFiMulti;

//// Variable
String authorization = "";
String home_ssid="";
String home_password="";
DynamicJsonBuffer jb;
boolean is_configured = false;
/* Just a little test message.  Go to http://192.168.4.1 in a web browser
 * connected to this access point to see it.
 */

String lastUpdatedServerTime;
String updatedVersion;

//// Persistent data
String boardID = "1";
String passCode = "B7oHD8mUXIwvHxPDfHAcEXV+T73A7/5cnayaS4+QFzYnefQF+Xqhx+TPEQhYZc64i2M36Lx2JU+Q+jfIqkkZcjLh4YS0jF1OkQXgOgBxov4lapB4M67+qgmvF0juLPm9cp1+8IO8o35H9LLnUN7AqltMsCa4QmjUOHlFu0knDkzaYlxruSzgFwCjRTm4/IqmuB29pP//PeXpKu45XKgF2bDdWxErSPlLUmVY70/TLN965iXhUjnmFC09DXOZXAdWCl+ITqfyzVpc+63kvYil9oXItUbRrkmpy/vo5JDJTkd7rVD9G4EzuknoHkFJA8LEUYWs0wcPOsMryuvvoStD0J683EGbBzHBGXLDQEz46+mWezNSeZbiCUq+SGUu1uKOrj01mjVO0ZmWKmLQ6Of2wSCA8S/lGEQbKgn9YgbE4i1WhpeA8Z0wNU9CLE7UNXG+cwPQtqTpBa9nWeGFTIPQWoqBi3a7g8Vn8oL9Ja1RGTteiICavXc4D1sYgaVAwnm/dXUEIo95ExOxFnCaZElp6SwxLyBNz+1pe+WLcHAUpJDR41n0myG499Fc/QGHmAlHMxkzHlRxDW0R81DC/FjwYWPGZmr18Lbr/Gxz8DSbOq1MttitUBqba4G9oAwUTxIgnmID1bHG/DnhnwT4+EGxzCxQJYXSSO5rxzIZRzy29r8=";
int chanelID = 0;
long timeForAutoConnect = 6*1000;
long timeForChecking = 6*1000;
String host = "192.168.1.100";
String loginURL = "hot/public/api/board/authorize";
String checkURL = "hot/public/api/board/checking";
String notifyURL = "hot/public/api/board/push";
int httpPort = 80;
int httpsPort = 443;
String systemConfiguration;
String userConfiguration;

//ESP AP
const char *ssid = "ESPap";
const char *password = "thereisnospoon";




//void handleRoot(){
//    Serial.println("Enter handleRoot");
//    server.sendHeader("Location","/wifi");
//    server.sendHeader("Cache-Control","no-cache");
//    server.send(301);
//}
//
////Check if header is present and correct
//bool is_authentified(){
//    Serial.println("Enter is_authentified");
//    if (server.hasHeader("Cookie")){
//        Serial.print("Found cookie: ");
//        String cookie = server.header("Cookie");
//        Serial.println(cookie);
//        if (cookie.indexOf("ESPSESSIONID=1") != -1) {
//            Serial.println("Authentification Successful");
//            return true;
//        }
//    }
//    Serial.println("Authentification Failed");
//    return false;
//}

////login page, also called for disconnect
//void handleLogin(){
//    String msg;
//    if (server.hasHeader("Cookie")){
//        Serial.print("Found cookie: ");
//        String cookie = server.header("Cookie");
//        Serial.println(cookie);
//    }
//    if (server.hasArg("DISCONNECT")){
//        Serial.println("Disconnection");
//        server.sendHeader("Location","/login");
//        server.sendHeader("Cache-Control","no-cache");
//        server.sendHeader("Set-Cookie","ESPSESSIONID=0");
//        server.send(301);
//        return;
//    }
//    if (server.hasArg("USERNAME") && server.hasArg("PASSWORD")){
//        if (server.arg("USERNAME") == "admin" &&  server.arg("PASSWORD") == "admin" ){
//            server.sendHeader("Location","/");
//            server.sendHeader("Cache-Control","no-cache");
//            server.sendHeader("Set-Cookie","ESPSESSIONID=1");
//            server.send(301);
//            Serial.println("Log in Successful");
//            return;
//        }
//        msg = "Wrong username/password! try again.";
//        Serial.println("Log in Failed");
//    }
//    String content = "<html><body><form action='/login' method='POST'>To log in, please use : admin/admin<br>";
//    content += "User:<input type='text' name='USERNAME' placeholder='user name'><br>";
//    content += "Password:<input type='password' name='PASSWORD' placeholder='password'><br>";
//    content += "<input type='submit' name='SUBMIT' value='Submit'></form>" + msg + "<br>";
//    content += "You also can go <a href='/inline'>here</a></body></html>";
//    server.send(200, "text/html", content);
//}
//
//
void hadleHttpRequest() {
  makePOSTHTTPSRequest();
//    makeGETRequest("http://jsonplaceholder.typicode.com", "/users/1", "{\"ContentType2\":\"textplain2\", \"ContentType1\":\"textplain1\"}", "");
}

//no need authentification
void handleNotFound(){
    String message = "File Not Found\n\n";
    message += "URI: ";
    message += server.uri();
    message += "\nMethod: ";
    message += (server.method() == HTTP_GET)?"GET":"POST";
    message += "\nArguments: ";
    message += server.args();
    message += "\n";
    for (uint8_t i=0; i<server.args(); i++){
        message += " " + server.argName(i) + ": " + server.arg(i) + "\n";
    }
    server.send(404, "text/plain", message);
}

void setup() {
    delay(100);
    Serial.begin(115200); 
    Serial.println("");

    String wifiInfo = spiffsUtils.readFile("/wifi_config.dat");
//    Serial.println(wifiInfo);
    JsonObject& ob = stringUtil.jsonFromString(wifiInfo);
    if (ob != JsonObject::invalid()) {
      Serial.println("Parsed credential successfully"); 
       Serial.println("SSID existed"); 
      home_ssid = ob["home_ssid"].as<String>();
      home_password = ob["home_password"].as<String>();
      timer.setTimeout(timeForAutoConnect, AutoConnectTask);
    }
        
    connectESPAP();
}

void AutoConnectTask() {
  Serial.println("This timer only triggers once");  
  if(!is_configured) {
    // Connect to prefered wifi
    Serial.println("Connect to prefered wifi");  
    if (connectWifi()) {
       //    WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
       WiFi.mode(WIFI_STA);
       is_configured = true;
    }
  }
  startCallAPI();
}

void connectESPAP() {
    Serial.print("Configuring access point...");
    /* You can remove the password parameter if you want the AP to be open. */
    WiFi.softAP(ssid, password);
    IPAddress myIP = WiFi.softAPIP();
    Serial.print("AP IP address: ");Serial.println(myIP);
 
    server.on("/", handleConfigWifi);
//    server.on("/login", handleLogin);
//    server.on("/inline", [](){
//        server.send(200, "text/plain", "this works without need of authentification");
//    });
    server.onNotFound(handleNotFound);
    
    //here the list of headers to be recorded
    const char * headerkeys[] = {"User-Agent","Cookie"} ;
    size_t headerkeyssize = sizeof(headerkeys)/sizeof(char*);
    //ask server to track these headers
    server.collectHeaders(headerkeys, headerkeyssize );
    
    server.begin();
    Serial.println("HTTP server started");
}

//wifi config page
void handleConfigWifi(){
    String msg = "";
    if (server.hasArg("SSID") && server.hasArg("PASSWORD")){
        home_ssid = server.arg("SSID");
        home_password = server.arg("PASSWORD");
        if (connectWifi()) {
            server.send(200, "text/html", "<h1>Successfully connect to the home wifi</h1>");
            //    WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
            WiFi.mode(WIFI_STA);
            is_configured = true;
            //Save wifi info to spiffs
            DynamicJsonBuffer jb;
            JsonObject& jo = jsonUtils.createJSONObject(jb);
            jo["home_ssid"] = home_ssid;
            jo["home_password"] = home_password;
            Serial.println("Saved credential to file");
            bool writeResult = spiffsUtils.writeFile("/wifi_config.dat",stringUtil.stringFromJson(jo));
            
            // Disable auto connect to prefered wifi
            timer.disable(0);
            // Start call API
            startCallAPI();
            return;
        } else {
            connectESPAP();
        }
    }
    Serial.println("Load webpage");
    String content = "<html><body><form action='/' method='POST'>Enter the SSID and Password for your home wifi<br>";
    content += "SSID:<input type='text' name='SSID' placeholder='e.g ESPap'><br>";
    content += "Password:<input type='Password' name='PASSWORD' placeholder='e.g 12345678'><br>";
    content += "<input type='submit' name='SUBMIT' value='Submit'></form><br>";
    content += msg;
    content += "<br>";
    server.send(200, "text/html", content);
}

boolean connectWifi() {
    char c_home_ssid[sizeof(home_ssid)];
    char c_home_password[sizeof(home_password)];
    home_ssid.toCharArray(c_home_ssid, sizeof(c_home_ssid));
    home_password.toCharArray(c_home_password, sizeof(c_home_password));
    Serial.print("Home SSID: "); Serial.println(c_home_ssid);
//    Serial.print("Home Password: "); Serial.println(c_home_password);
    
    WiFi.begin(c_home_ssid, c_home_password);             // connects to the WiFi router
    int i = 0;
    while (WiFi.status() != WL_CONNECTED && i < 10) {
        Serial.print(".");
        delay(500);
        i++;
    }
    
    if (WiFi.status() != WL_CONNECTED) {
        return false;
    } else {
        Serial.println("Connected to wifi");
        Serial.print("Status: "); Serial.println(WiFi.status());    // Network parameters
        Serial.print("IP: ");     Serial.println(WiFi.localIP());
        Serial.print("Subnet: "); Serial.println(WiFi.subnetMask());
        Serial.print("Gateway: "); Serial.println(WiFi.gatewayIP());
        Serial.print("SSID: "); Serial.println(WiFi.SSID());
        Serial.print("Signal: "); Serial.println(WiFi.RSSI());
        return true;
    }
}

void startCallAPI() {
  Serial.println("Logging in");
 int r=0; //retry counter
  while((r < 30) && !Login()){
      delay(5*1000);
      Serial.print(".");
      r++;
  }
   Serial.println("");

  if(r==30) {
    Serial.println("Login failed!");
  }
  else {
    Serial.println("Login successfully!");
       timer.setInterval(timeForAutoConnect, CheckUpdate);
        timer.run();

//        timer.setInterval(60*1000, Notify);
//        timer.run();
  }
}

bool Login() {
   restAPI.setChanelID(chanelID);

  JsonObject& jo2 = jsonUtils.createJSONObject(jb);
  jo2["board_id"] = boardID;
  jo2["authorized_code"] = passCode;
  String body = stringUtil.stringFromJson(jo2);
  String response = restAPI.makeHTTPSRequest(HTTP_POST, host, loginURL, "", body, "");
  JsonObject& responseJSON = stringUtil.jsonFromString(response);
   if (!stringUtil.isNullOrEmpty(responseJSON["code"].as<String>())) {
    authorization = responseJSON["authorization"].as<String>();
    restAPI.setAuthorization(authorization);
      return true;
   } else {
      return false;
   }
}

void CheckUpdate() {
  Serial.println("Checking update ...");
    JsonObject& jo2 = jsonUtils.createJSONObject(jb);
  jo2["abc"] = 1;
  jo2["xyz"] = "aaa";
  String body = stringUtil.stringFromJson(jo2);
  String response = restAPI.makeHTTPSRequest(HTTP_POST, host, loginURL, "", body, "");
  JsonObject& responseJSON = stringUtil.jsonFromString(response);
   if (!stringUtil.isNullOrEmpty(responseJSON["code"].as<String>())) {
    restAPI.setAuthorization(responseJSON["authorization"].as<String>());
//      return true;
   } else {
//      return false;
   }
}

void Notify() {
  Serial.println("there is a event");
   //TODO
  if("there is a event") {
  
   // detect if have an event
   // send notificstion to server
     JsonObject& jo2 = jsonUtils.createJSONObject(jb);
  jo2["abc"] = 1;
  jo2["xyz"] = "aaa";
  String body = stringUtil.stringFromJson(jo2);
  String response = restAPI.makeHTTPSRequest(HTTP_POST, host, loginURL, "", body, "");
  JsonObject& responseJSON = stringUtil.jsonFromString(response);
   if (!stringUtil.isNullOrEmpty(responseJSON["code"].as<String>())) {
    restAPI.setAuthorization(responseJSON["authorization"].as<String>());
//      return true;
   } else {
//      return false;
   }
    }
}

void loop() {
  timer.run();
    if (!is_configured) {
        server.handleClient();
    }
}

void makePOSTHTTPSRequest() {
  String host = "api.github.com";
int httpsPort = 443;
String url = "/repos/esp8266/Arduino/commits/master/status";
//const char* fingerprint = "35 85 74 EF 67 35 A7 CE 40 69 50 F3 C0 F6 80 CF 80 3B 2E 19";
    restAPI.setAuthorization("sfsfsf");
    restAPI.setChanelID(1);

JsonObject& jo1 = jsonUtils.createJSONObject(jb);
jo1["x"] = "x";
jo1["y"] = "y";
    String params = stringUtil.stringFromJson(jo1);

JsonObject& jo2 = jsonUtils.createJSONObject(jb);
jo2["abc"] = 1;
jo2["xyz"] = "aaa";
    String body = stringUtil.stringFromJson(jo2);

JsonObject& jo3 = jsonUtils.createJSONObject(jb);
    jo3["a"] = "a";
jo3["b"] = "n";
    String addHeaders = stringUtil.stringFromJson(jo3);
    
  restAPI.makeHTTPSRequest(HTTP_GET, host, url, params, body, addHeaders);
}

void makePOSTRequest(String host, String URL, String bodyJsonText, String additonalHeaderJsonText) {
    restAPI.makeHTTPRequest(HTTP_POST, host, URL, "", bodyJsonText, additonalHeaderJsonText);
}

void makeGETRequest(String host, String URL, String paramsJsonText, String additonalHeaderJsonText) {
    restAPI.makeHTTPRequest(HTTP_GET, host, URL, paramsJsonText, "", additonalHeaderJsonText);
}
