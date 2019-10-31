
#if ARDUINO >= 100
#include "Arduino.h"
#else
#include "WProgram.h"
#endif

#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WiFiMulti.h>
#include <WiFiClientSecure.h> 
#include <FS.h>

#include "StringUtil.h"

class RestAPI {
    
public:
    String authorization_code;
    int chanelID;
    StringUtil *stringUtil;
    WiFiClientSecure *httpsClient;
    RestAPI();
    RestAPI(String authorization, int _chanelID);
    HTTPMethod httpMethodFromString(String text);
    String labelHTTPMethod(HTTPMethod httpMethod);
    void makeHTTPRequest(HTTPMethod httpMethod, String URL, String paramsJsonText, String bodyJsonText, String additonalHeaderJsonText);
    void makeHTTPSRequest(HTTPMethod httpMethod, char *host, int httpsPort, String URL, String paramsJsonText, String bodyJsonText, String additonalHeaderJsonText);
    void setDefaultHeaders(HTTPClient& http);
    void setAdditionalHeaders(HTTPClient& http, String additonalHeaderJsonText, boolean isLast);
    ~RestAPI();
    
private:
    
};
