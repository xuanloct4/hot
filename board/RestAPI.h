
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
    StringUtil *stringUtil;
    WiFiClientSecure httpsClient;
    RestAPI();
    RestAPI(String authorization, int _chanelID);
    HTTPMethod httpMethodFromString(String text);
    String labelHTTPMethod(HTTPMethod httpMethod);
    String makeHTTPRequest(HTTPMethod httpMethod, String host, String URL, String paramsJsonText, String bodyJsonText, String additonalHeaderJsonText, int httpPort = 80);
    String makeHTTPSRequest(HTTPMethod httpMethod, String host, String URL, String paramsJsonText, String bodyJsonText, String additonalHeaderJsonText, int httpsPort = 443);
    void setDefaultHeaders(HTTPClient& http);
    void setAdditionalHeaders(HTTPClient& http, String additonalHeaderJsonText, boolean isLast);
    String defaultHTTPSHeaders();
    String additionalHTTPSHeaders(String additonalHeaderJsonText);
    void setAuthorization(String code);
    void setChanelID(int id);
    ~RestAPI();
    
private:
    String authorization_code;
    int chanelID;
    String defaultHeadersJSON();
};
