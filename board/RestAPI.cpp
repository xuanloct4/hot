
#include "RestAPI.h"

RestAPI::RestAPI() {
   stringUtil = new StringUtil();
   httpsClient = new WiFiClientSecure();  
}

RestAPI::RestAPI(String authorization, int _chanelID) {
    RestAPI();
    authorization_code = authorization;
    chanelID = _chanelID;
}

RestAPI::~RestAPI() {
  delete(stringUtil);
  delete(httpsClient);
}
  

HTTPMethod RestAPI::httpMethodFromString(String text) {
    if (text.equalsIgnoreCase("GET")) {
        return HTTP_GET;
    } else if (text.equalsIgnoreCase("POST")) {
        return HTTP_POST;
    } else if (text.equalsIgnoreCase("PUT")) {
        return HTTP_PUT;
    } else if (text.equalsIgnoreCase("PATCH")) {
        return HTTP_PATCH;
    } else if (text.equalsIgnoreCase("DELETE")) {
        return HTTP_DELETE;
    } else if (text.equalsIgnoreCase("OPTIONS")) {
        return HTTP_OPTIONS;
    } else {
        return HTTP_ANY;
    }
}
    
String RestAPI::labelHTTPMethod(HTTPMethod httpMethod) {
    String methodLabel = "";
    switch (httpMethod) {
        case HTTP_GET:
            methodLabel= "GET";
            break;
        case HTTP_POST:
            methodLabel= "POST";
            break;
        case HTTP_PUT:
            methodLabel= "PUT";
            break;
        case HTTP_PATCH:
            methodLabel= "PATCH";
            break;
        case HTTP_DELETE:
            methodLabel= "DELETE";
            break;
        case HTTP_ANY:
            methodLabel= "ANY";
            break;
        case HTTP_OPTIONS:
            methodLabel= "OPTIONS";
            break;
        default:
            break;
    }
    
    return methodLabel;
}

void RestAPI::makeHTTPRequest(HTTPMethod httpMethod, String URL, String paramsJsonText, String bodyJsonText, String additonalHeaderJsonText) {
    Serial.println("Checking Wifi status");
    if (WiFi.status() == WL_CONNECTED) { //Check WiFi connection status
        Serial.println("---------------------------------------------------------------------------------");
        Serial.println("Start making HTTP request");
        HTTPClient http;  //Declare an object of class HTTPClient
        int httpCode = -9999;
        String methodLabel = labelHTTPMethod(httpMethod);
        
        switch (httpMethod) {
            case HTTP_GET:
            {
                String queryParamsURL = URL;
                String queryParams = "";
                JsonObject& paramsJsonObject = stringUtil->jsonFromString(paramsJsonText);
                for (auto kv : paramsJsonObject) {
                    if (queryParams.length() == 0) {
                        queryParams += "?";
                    } else {
                        queryParams += "&";
                    }
                    String tString = kv.key;
                    tString += "=";
                    tString += kv.value.as<char*>();
                    tString.trim();
                    queryParams += tString;
                }
                queryParamsURL += queryParams;
                Serial.printf("[HTTP] [%s] ", methodLabel.c_str());Serial.print("URL: ");Serial.println(queryParamsURL);
                http.begin(queryParamsURL);  //Specify request destination
                setDefaultHeaders(http);
                setAdditionalHeaders(http, additonalHeaderJsonText, true);
                httpCode = http.GET();
            }
                break;
            case HTTP_POST:
            {
                Serial.printf("[HTTP] [%s] ", methodLabel.c_str());Serial.print("URL: ");Serial.println(URL);
                http.begin(URL);  //Specify request destination
                setDefaultHeaders(http);
                setAdditionalHeaders(http, additonalHeaderJsonText, true);
                httpCode = http.POST(bodyJsonText);
            }
                break;
            default:
                Serial.println("The request method is not supported");
                return;
        }
        
        Serial.print("httpCode: ");
        Serial.println(httpCode);
        if (httpCode > 0) { //Check the returning code
            String payload = http.getString();   //Get the request response payload
            Serial.print("Response: ");Serial.println(payload);                     //Print the response payload
        } else {
            Serial.printf("[HTTP] [%s]... failed, error: %s\n", methodLabel.c_str(), http.errorToString(httpCode).c_str());
        }
        
        http.end();   //Close connection
        Serial.println("End making HTTP request");
        Serial.println("---------------------------------------------------------------------------------");
    } else {
        Serial.println("Problem when connecting to the Wifi");
    }
}

void RestAPI::makeHTTPSRequest(HTTPMethod httpMethod, char *host, int httpsPort, String URL, String paramsJsonText, String bodyJsonText, String additonalHeaderJsonText) {

////Link to read data from https://jsonplaceholder.typicode.com/comments?postId=7
////Web/Server address to read/write from 
//  const char *host = "postman-echo.com";
//  const int httpsPort = 443;  //HTTPS= 443 and HTTP = 80
//SHA1 finger print of certificate use web browser to view and copy
  const char *fingerprint = "A6 5A 41 2C 0E DC FF C3 16 E8 57 E9 F2 C3 11 D2 71 58 DF D9";
  String authorization_code = "we";
  String msg = "say=Hi&to=Mom";
//  String URL;
//  //POST Data
//  URL = "/post";

//  const char* host = "api.dgs.com";
//  const int httpsPort = 443;
//  String URL = "/ccs-int/v1/applicationdatalogging/1.0";
//  String msg = "";

  Serial.print("connecting to : '");
  Serial.print(host);
  Serial.println("'");

//// Verify Fingerprint
//  Serial.printf("Using fingerprint '%s'\n", fingerprint);
//if (httpsClient->verify(fingerprint, host)) {
//    Serial.println("certificate matches");
//  } else {
//    Serial.println("certificate doesn't match");
//  }

//// Or load certificate file
//const char* certyficateFile = "/client.cer";
//if (!SPIFFS.begin())
//{
//  Serial.println("Failed to mount the file system");
//  return;
//}
//
//Serial.printf("Opening %s", certyficateFile);
//File crtFile = SPIFFS.open(certyficateFile, "r");
//if (!crtFile)
//{
//  Serial.println(" Failed!");
//}
//
//Serial.printf("Loading %s", certyficateFile);
//if (!httpsClient->loadCertificate(crtFile))
//{
//  Serial.println(" Failed!");
//}
//crtFile.close();

  httpsClient->setTimeout(15000); // 15 Seconds
  
//  Serial.print("HTTPS Connecting");
  int r=0; //retry counter
  while((!httpsClient->connect(host, httpsPort)) && (r < 30)){
      delay(100);
      Serial.print(".");
      r++;
  }
  
  if(r==30) {
    Serial.println("Connection failed");
  }
  else {
    Serial.println("Connected to web");
  }
  
  Serial.print("requesting URL: '");
  Serial.print(URL);
  
  /*
   POST /post HTTP/1.1
   Host: postman-echo.com
   Content-Type: application/json
   Content-Length: 13
  
   say=Hi&to=Mom
    
   */
 
  httpsClient->print(labelHTTPMethod(httpMethod) + URL + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Authorization: " + authorization_code + "\r\n" +
               "Chanel-ID: " + chanelID + "\r\n" +
               "Content-Type: application/json;charset=utf-8" + "\r\n" +
               "User-Agent: ESP8266\r\n" +
               "Connection: close\r\n"
               "Content-Length: "+  msg.length() + "\r\n" +
               "\r\n" +
                msg + "\r\n");
 
  Serial.println("request sent");
                  
  while (httpsClient->connected()) {
    String line = httpsClient->readStringUntil('\n');
    if (line == "\r") {
      Serial.println("headers received");
      break;
    }
  }

  unsigned long timeout = millis();
  while (httpsClient->available() == 0) {
    if (millis() - timeout > 5000) {
        Serial.println(">>> Client Timeout !");
        httpsClient->stop();
        return;
    }
  }
 
  Serial.println("reply was:");
  Serial.println("==========");
  String line;
  while(httpsClient->available()){        
    line = httpsClient->readStringUntil('\n');  //Read Line by Line
    Serial.println(line); //Print response
  }
  Serial.println("==========");
  Serial.println("closing connection");
}

void RestAPI::setDefaultHeaders(HTTPClient& http) {
    Serial.println("Headers: [");
    String headerJsonString = "{";
    if (!stringUtil->isNullOrEmpty(authorization_code)) {
    headerJsonString += "\"Authorization\": ";
    headerJsonString += "\"";
    headerJsonString += authorization_code;
    headerJsonString += "\"";
    headerJsonString +=  ",";
    }

    headerJsonString += "\"Chanel-ID\": ";
    headerJsonString += chanelID;
    headerJsonString +=  ",";
    
    headerJsonString += "\"Content-Type\": ";
    headerJsonString += "\"application/json;charset=utf-8\"";
    headerJsonString +=  ",";
     
    headerJsonString += "\"User-Agent\": ";
    headerJsonString += "\"ESP8266\"";
    headerJsonString +=  ",";

    headerJsonString += "\"Connection\": ";
    headerJsonString += "\"close\"";
    
    setAdditionalHeaders(http, headerJsonString, false);
}

void RestAPI::setAdditionalHeaders(HTTPClient& http, String additonalHeaderJsonText, boolean isLast) {
    JsonObject& additonalHeaderJsonObject = stringUtil->jsonFromString(additonalHeaderJsonText);
    for (auto kv : additonalHeaderJsonObject) {
        Serial.print(kv.key);Serial.print(", ");Serial.println(kv.value.as<char*>());
        http.addHeader(kv.key, kv.value.as<char*>());
    }
    if (isLast) {
        Serial.println("]");
    }
}
