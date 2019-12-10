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
#include "DateTimeUtils.h"

//// Utils
DateTimeUtils dateTimeUtils;
StringUtil stringUtil;
JSONUtils jsonUtils;
SPIFFSUtils spiffsUtils;
RestAPI restAPI;
SimpleTimer timer;
WiFiClientSecure httpsClient;
ESP8266WebServer server(80);
//ESP8266WiFiMulti WiFiMulti;

//// Variable
String updatedVersion = "0";
String lastUpdatedServerTime = "2019-01-01 00:00:00";
int pirState = LOW;             // we start, assuming no motion detected
int pirValue = 0;                    // variable for reading the pin status
String authorization = "";
String home_ssid="";
String home_password="";
DynamicJsonBuffer jb;
boolean is_configured = false;
/* Just a little test message.  Go to http://192.168.4.1 in a web browser
* connected to this access point to see it.
*/
String boardConfigString;

//// Persistent data
String defaultJson = "{\"lastSupportedTime\":\"2050-01-0100:00:00\",\"boardID\":\"1\",\"passCode\":\"g1mj0lypTdtr1LEJnWdR2Kcvli1zZh/CmCgWJXFjOjepv7D3FAMQ9XVgrld7vRWEyawPKkhkzlnEtL2d0YoeGrD6EaUdP2WlXXTM7U8JO0s9bGv4Sw44KDX6J7STw6iOOMJl9hcL9uOQZKgM/0J0/qmrWE8mTB9Sm3aokmRo3PVmcdbVTVJJiYKIqOgm0CmeuQpo+yRkpTDyhd21R2pWvB5S8wX2MgJPohdrAvDJXmDEgOLqyug9fqFxt5X98+p0o9WkdKxSpOeq+m8S3Bbb8KakHNox5o2vvq48A4tAOjID2V/izyzQ3JJ0tHWmfH5bWmyy9OS3iJHffiiNXzD4nD0QL54niooWLLXXT3Ic7rIhWzJ5jnBX/MvDMenQPP6YsbgiziLcdEk8LjIIYMJ8uMIErHdDqjR/vnFSvJ8S7k5OY4AcivUWeoIvHHNcBRZAa/CzA+bD6rtaj6a/C3Z5JtRcwprr3W/wjjkbaahTBXaMAgQlTP+CPGZArjGCkpYA3O60qLvZ95bQg0xSRWC4sTrj2iiK7loeAEtKYDxvS5JIqlFJ/VZ5Regg2Gn8AAx0xWSA+TihoN2soHyBnu4z4ofk73QRwBwVJCSyZ8Tl12A46a7/4tY80SfZuaooIcY/qMAV8EqOHfv6cKOhJluJ5ZxwQik3v6NbuYQ46SFUFmw=\",\"chanelID\":0,\"timeForAutoConnect\":6000,\"timeForChecking\":6000,\"timeForAlarmRepeat\":1000,\"retryTime\":5000,\"alarmRepeat\":300,\"host\":\"http://192.168.1.7\",\"loginURL\":\"/hot/public/api/board/authorize\",\"checkURL\":\"/hot/public/api/board/configuration\",\"notifyURL\":\"/hot/public/api/device/push\",\"httpPort\":80,\"httpsPort\":443,\"systemConfiguration\":{},\"userConfiguration\":{},\"buzzerPin\":4,\"pirPin\":15,\"ssid\":\"ESPap\",\"password\":\"thereisnospoon\", \"wifiConfigFile\": \"/wifi_config.dat\", \"boardConfigFile\": \"/board_config.dat\"}";

//// Keys
String lastSupportedTimeKey = "lastSupportedTime";
String boardIDKey = "boardID";
String passCodeKey = "passCode";
String chanelIDKey = "chanelID";
String timeForAutoConnectKey = "timeForAutoConnect";
String timeForCheckingKey = "timeForChecking";
String timeForAlarmRepeatKey = "timeForAlarmRepeat";
String retryTimeKey = "retryTime";
String alarmRepeatKey = "alarmRepeat";
String hostKey = "host";                 //with prefix http or https
String loginURLKey = "loginURL";
String checkURLKey = "checkURL";
String notifyURLKey = "notifyURL";
String httpPortKey = "httpPort";
String httpsPortKey = "httpsPort";
String systemConfigurationKey = "systemConfiguration";
String userConfigurationKey = "userConfiguration";
String buzzerPinKey = "buzzerPin";        // choose the input pin (for buzzer sensor)
String pirPinKey = "pirPin";              // choose the input pin (for PIR sensor)
String ssidKey = "ssid";                  //ESP AP SSID
String passwordKey = "password";          //ESP AP Pass
String wifiConfigFileKey = "wifiConfigFile";
String boardConfigFileKey = "boardConfigFile";

//// Get from Board config JSON object
long getLong(String key) {
long value = jsonUtils.getLong(getBoardConfigJO(), stringUtil.convertToChar(key));
return value;
}

int getInteger(String key) {
int value = jsonUtils.getInteger(getBoardConfigJO(), stringUtil.convertToChar(key));
return value;
}

String getString(String key) {
String value = jsonUtils.getString(getBoardConfigJO(), stringUtil.convertToChar(key));
return value;
}

double getDouble(String key) {
double value = jsonUtils.getDouble(getBoardConfigJO(), stringUtil.convertToChar(key));
return value;
}

JsonObject& getObject(String key) {
JsonObject& value = jsonUtils.getObject(getBoardConfigJO(), stringUtil.convertToChar(key));
return value;
}

JsonArray& getArray(String key) {
JsonArray& value = jsonUtils.getArray(getBoardConfigJO(), stringUtil.convertToChar(key));
return value;
}

JsonObject& getBoardConfigJO() {
return stringUtil.jsonFromString(boardConfigString);
}

//// Update configuration
void updateConfiguration() {
String text = spiffsUtils.readFile(getString(boardConfigFileKey));
text.trim();
if (boardConfigString == "" || stringUtil.jsonFromString(text) == JsonObject::invalid()) {
boardConfigString = defaultJson;
}
}

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
updateConfiguration();
delay(100);
Serial.begin(115200);
pinMode(getInteger(pirPinKey), INPUT);     // declare sensor as input
pinMode (getInteger(buzzerPinKey), OUTPUT) ;     // declare buzzer as input

Serial.println("");

String wifiInfo = spiffsUtils.readFile(getString(wifiConfigFileKey));
//    Serial.println(wifiInfo);
JsonObject& ob = stringUtil.jsonFromString(wifiInfo);
if (ob != JsonObject::invalid()) {
Serial.println("Parsed credential successfully");
Serial.println("SSID existed");
home_ssid = ob["home_ssid"].as<String>();
home_password = ob["home_password"].as<String>();
timer.setTimeout(getLong(timeForAutoConnectKey), AutoConnectTask);
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
WiFi.softAP(stringUtil.convertToChar(getString(ssidKey)), stringUtil.convertToChar(getString(passwordKey)));
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
bool writeResult = spiffsUtils.writeFile(getString(wifiConfigFileKey),stringUtil.stringFromJson(jo));

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
delay(getLong(retryTimeKey));
Serial.print(".");
r++;
}
Serial.println("");

if(r==30) {
Serial.println("Login failed!");
}
else {
Serial.println("Login successfully!");
timer.setInterval(getLong(timeForCheckingKey), CheckUpdate);
timer.run();
}
}

bool Login() {
restAPI.setChanelID(getInteger(chanelIDKey));

JsonObject& jo2 = jsonUtils.createJSONObject(jb);
jo2["board_id"] = getString(boardIDKey);
jo2["authorized_code"] = getString(passCodeKey);
String body = stringUtil.stringFromJson(jo2);
// String response = restAPI.makeHTTPSRequest(HTTP_POST, host, loginURL, "", body, "");
String response = restAPI.makeHTTPRequest(HTTP_POST, getString(hostKey), getString(loginURLKey), "", body, "");
JsonObject& responseJSON = stringUtil.jsonFromString(response);
if (!stringUtil.isNullOrEmpty(responseJSON["token"].as<String>())) {
authorization = responseJSON["token"].as<String>();
Serial.print("Token: ");Serial.println(authorization);
restAPI.setAuthorization(authorization);
return true;
} else {
return false;
}
}

void CheckUpdate() {
Serial.println("Checking update ...");

JsonObject& jo1 = jsonUtils.createJSONObject(jb);
jo1["start"] = lastUpdatedServerTime;
jo1["end"] = getString(lastSupportedTimeKey);

JsonObject& jo = jsonUtils.createJSONObject(jb);
jo["last_updated_timestamp_spec"] = jo1;
jo["isAnd"] = true;
jo["is_deleted"] = false;
jo["is_activated"] = true;

String body = stringUtil.stringFromJson(jo);

String response = restAPI.makeHTTPRequest(HTTP_POST, getString(hostKey), getString(checkURLKey), "", body, "");
Serial.println(response);
JsonObject& responseJSON = stringUtil.jsonFromString(response);
Serial.print("JSON[][]:   ");Serial.println(responseJSON["list"][0]["strings"].as<String>());



//    if (!stringUtil.isNullOrEmpty(responseJSON["code"].as<String>())) {

// Merge
// Exclude the deleted and inactive items
// Save
// Update variable


String boardConfig = spiffsUtils.readFile(getString(boardConfigFileKey));
//    Serial.println(boardConfig);
JsonObject& bc = stringUtil.jsonFromString(boardConfig);
jsonUtils.merge(responseJSON, bc);

Serial.println("Saved configuration to file");
bool writeResult = spiffsUtils.writeFile(getString(boardConfigFileKey),stringUtil.stringFromJson(responseJSON));

updateConfiguration();

// TODO
// Do command

//      return true;
//    } else {
//      return false;
//    }
}

void Ringing() {
tone(getInteger(buzzerPinKey), 1000); // Send 1KHz sound signal...
delay(1000);        // ...for 1 sec
tone(getInteger(buzzerPinKey), 10000);
delay(1000);
tone(getInteger(buzzerPinKey), 100);
delay(1000);
noTone(getInteger(buzzerPinKey));     // Stop sound...
delay(1000);        // ...for 1sec
}

void NotifyAndRing(String message, double value) {
Serial.println("there is a event");
//TODO
// check if the event happens in included time range and out of excluded time range
// buzzer
if (true) {
timer.setTimer(getLong(timeForAlarmRepeatKey), Ringing, getLong(alarmRepeatKey));

// send notificstion to server
JsonObject& jo2 = jsonUtils.createJSONObject(jb);
jo2["message"] = message;
jo2["value"] = value;
String body = stringUtil.stringFromJson(jo2);
String response = restAPI.makeHTTPSRequest(HTTP_POST, getString(hostKey), getString(notifyURLKey), "", body, "");
JsonObject& responseJSON = stringUtil.jsonFromString(response);
Serial.println(response);
}
}

void motionDetect() {
pirValue = digitalRead(getInteger(pirPinKey));  // read input value
//  Serial.print("Value: ");Serial.println(pirValue);

if (pirValue == HIGH) {            // check if the input is HIGH
NotifyAndRing("motion_detected", 1);
if (pirState == LOW) {
// we have just turned on
Serial.println("Motion detected!");
// We only want to print on the output change, not state
pirState = HIGH;
}
} else {
if (pirState == HIGH){
// we have just turned off
Serial.println("Motion ended!");
// We only want to print on the output change, not state
pirState = LOW;
}
}
}

void loop() {
timer.run();
if (!is_configured) {
server.handleClient();
}

motionDetect();
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
