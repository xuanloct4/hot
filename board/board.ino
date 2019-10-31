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
StringUtil stringUtil;
JSONUtils jsonUtils;
SPIFFSUtils spiffsUtils;
RestAPI restAPI;
SimpleTimer timer;

/* Set these to your desired credentials. */
const char *ssid = "ESPap";
const char *password = "thereisnospoon";

String home_ssid="";
String home_password="";
//String home_ssid = "Duong2002";
//String home_password = "08122000";

//String home_ssid = "ascend01";
//String home_password = "ascend@123";

ESP8266WebServer server(80);
//ESP8266WiFiMulti WiFiMulti;

boolean is_configured = false;
/* Just a little test message.  Go to http://192.168.4.1 in a web browser
 * connected to this access point to see it.
 */

//void handleRoot() {
//  String html = "<h1>Simple NodeMCU Web Server</h1><p><a href=\"LEDOn\"><button>ON</button></a>&nbsp;<a href=\"LEDOff\"><button>OFF</button></a></p>";
//
//  server.send(200, "text/html", html);
//}
//root page can be accessed only if authentification is ok
//void handleRoot(){
//  Serial.println("Enter handleRoot");
//  String header;
//  if (!is_authentified()){
//    server.sendHeader("Location","/login");
//    server.sendHeader("Cache-Control","no-cache");
//    server.send(301);
//    return;
//  }
//  String content = "<html><body><H2>hello, you successfully connected to esp8266!</H2><br>";
//  if (server.hasHeader("User-Agent")){
//    content += "the user agent used is : " + server.header("User-Agent") + "<br><br>";
//  }
//  content += "You can access this page until you <a href=\"/login?DISCONNECT=YES\">disconnect</a></body></html>";
//  server.send(200, "text/html", content);
//}

void handleRoot(){
    Serial.println("Enter handleRoot");
    server.sendHeader("Location","/wifi");
    server.sendHeader("Cache-Control","no-cache");
    server.send(301);
}

//Check if header is present and correct
bool is_authentified(){
    Serial.println("Enter is_authentified");
    if (server.hasHeader("Cookie")){
        Serial.print("Found cookie: ");
        String cookie = server.header("Cookie");
        Serial.println(cookie);
        if (cookie.indexOf("ESPSESSIONID=1") != -1) {
            Serial.println("Authentification Successful");
            return true;
        }
    }
    Serial.println("Authentification Failed");
    return false;
}

//login page, also called for disconnect
void handleLogin(){
    String msg;
    if (server.hasHeader("Cookie")){
        Serial.print("Found cookie: ");
        String cookie = server.header("Cookie");
        Serial.println(cookie);
    }
    if (server.hasArg("DISCONNECT")){
        Serial.println("Disconnection");
        server.sendHeader("Location","/login");
        server.sendHeader("Cache-Control","no-cache");
        server.sendHeader("Set-Cookie","ESPSESSIONID=0");
        server.send(301);
        return;
    }
    if (server.hasArg("USERNAME") && server.hasArg("PASSWORD")){
        if (server.arg("USERNAME") == "admin" &&  server.arg("PASSWORD") == "admin" ){
            server.sendHeader("Location","/");
            server.sendHeader("Cache-Control","no-cache");
            server.sendHeader("Set-Cookie","ESPSESSIONID=1");
            server.send(301);
            Serial.println("Log in Successful");
            return;
        }
        msg = "Wrong username/password! try again.";
        Serial.println("Log in Failed");
    }
    String content = "<html><body><form action='/login' method='POST'>To log in, please use : admin/admin<br>";
    content += "User:<input type='text' name='USERNAME' placeholder='user name'><br>";
    content += "Password:<input type='password' name='PASSWORD' placeholder='password'><br>";
    content += "<input type='submit' name='SUBMIT' value='Submit'></form>" + msg + "<br>";
    content += "You also can go <a href='/inline'>here</a></body></html>";
    server.send(200, "text/html", content);
}


//wifi config page
void handleConfigWifi(){
    String msg;
    if (server.hasArg("SSID") && server.hasArg("PASSWORD")){
        home_ssid = server.arg("SSID");
        home_password = server.arg("PASSWORD");
        if (connectWifi()) {
            server.send(200, "text/html", "<h1>Successfully connect to the home wifi</h1>");
            //    WiFi.mode(WIFI_OFF);        //Prevents reconnection issue (taking too long to connect)
            WiFi.mode(WIFI_STA);
            delay(500);
            is_configured = true;
            //Save wifi info to spiffs
            DynamicJsonBuffer jb;
            JsonObject& jo = jsonUtils.createJSONObject(jb);
            jo["home_ssid"] = home_ssid;
            jo["home_password"] = home_password;
            bool writeResult = spiffsUtils.writeFile("/wifi_config.dat",stringUtil.stringFromJson(jo));
            
            // Disable auto connect to prefered wifi
            timer.disable(1);
            // Start call API
            startCallAPI();
            return;
        } else {
            connectESPAP();
        }
    }
    String content = "<html><body><form action='/wifi' method='POST'>Enter the SSID and Password for your home wifi<br>";
    content += "SSID:<input type='text' name='SSID' placeholder='e.g ESPap'><br>";
    content += "Password:<input type='Password' name='PASSWORD' placeholder='e.g 12345678'><br>";
    content += "<input type='submit' name='SUBMIT' value='Submit'></form>" + msg + "<br>";
    server.send(200, "text/html", content);
}

boolean connectWifi() {
    char c_home_ssid[sizeof(home_ssid)];
    char c_home_password[sizeof(home_password)];
    home_ssid.toCharArray(c_home_ssid, sizeof(c_home_ssid));
    home_password.toCharArray(c_home_password, sizeof(c_home_password));
    Serial.print("Home SSID: "); Serial.println(c_home_ssid);
    Serial.print("Home Password: "); Serial.println(c_home_password);
    
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

void hadleHttpRequest() {
    makeGETRequest("http://jsonplaceholder.typicode.com/users/1", "{\"ContentType2\":\"textplain2\", \"ContentType1\":\"textplain1\"}", "");
    delay(30000);    //Send a request every 30 seconds
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
    delay(1000);
    Serial.begin(115200); 
    Serial.println("");

    String wifiInfo = spiffsUtils.readFile("/wifi_config.dat");
    JsonObject& ob = stringUtil.jsonFromString(wifiInfo);
    if (ob != JsonObject::invalid()) {
      if(ob["ssid"]) {
      home_ssid = ob["home_ssid"].as<String>();
      home_password = ob["home_password"].as<String>();
      timer.setTimeout(60*5*1000, OnceTask);
      timer.run();
      return;
      }
    }
      connectESPAP();
}

void OnceTask() {
  Serial.println("This timer only triggers once");  
  if(!is_configured) {
    // Connect to prefered wifi
    connectWifi();
  }

  startCallAPI();
}

void connectESPAP() {
    Serial.println();
    Serial.print("Configuring access point...");
    /* You can remove the password parameter if you want the AP to be open. */
    WiFi.softAP(ssid, password);
    IPAddress myIP = WiFi.softAPIP();
    Serial.print("AP IP address: ");Serial.println(myIP);
    
    server.on("/", handleRoot);
    server.on("/login", handleLogin);
    server.on("/inline", [](){
        server.send(200, "text/plain", "this works without need of authentification");
    });
    server.on("/wifi", handleConfigWifi);
    server.onNotFound(handleNotFound);
    
    //here the list of headers to be recorded
    const char * headerkeys[] = {"User-Agent","Cookie"} ;
    size_t headerkeyssize = sizeof(headerkeys)/sizeof(char*);
    //ask server to track these headers
    server.collectHeaders(headerkeys, headerkeyssize );
    
    server.begin();
    Serial.println("HTTP server started");
}

void startCallAPI() {
  bool isSuccess = login();
  if(isSuccess) {
       timer.setTimeout(60*1000, checkUpdate);
        timer.run();

        timer.setInterval(60*1000, checkUpdate);
        timer.run();

        timer.setInterval(60*1000, notify);
        timer.run();

    }
}

bool login() {
  return true;
}

void checkUpdate() {
  
}

void notify() {
   //TODO
  if("there is a event") {
  
   // detect if have an event
   // send notificstion to server
    }
}

void loop() {
    if (!is_configured) {
        server.handleClient();
    } else {
        hadleHttpRequest();
    }
}

void makePOSTRequest(String URL, String bodyJsonText, String additonalHeaderJsonText) {
    restAPI.makeHTTPRequest(HTTP_POST, URL, "", bodyJsonText, additonalHeaderJsonText);
}

void makeGETRequest(String URL, String paramsJsonText, String additonalHeaderJsonText) {
    restAPI.makeHTTPRequest(HTTP_GET, URL, paramsJsonText, "", additonalHeaderJsonText);
}
