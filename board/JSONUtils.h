
#if ARDUINO >= 100
#include "Arduino.h"
#else
#include "WProgram.h"
#endif

#include <ArduinoJson.h>
//#include "StringUtil.h"
#define  defaultNotFound     -999999999

class JSONUtils{
public:
    DynamicJsonBuffer jb;
 //   StringUtil *stringUtil;
    JSONUtils();
    ~JSONUtils();
    bool containsNestedKey(JsonObject& obj, char* key);
    void merge(JsonObject& dest, JsonObject& src);
    JsonVariant clone(DynamicJsonBuffer& jb, JsonVariant prototype);
    JsonObject& createJSONObject(DynamicJsonBuffer& jb);
    JsonArray& createJSONArray(DynamicJsonBuffer& jb);
    long getLong(JsonObject& obj, char* key);
    int getInteger(JsonObject& obj, char* key);
    String getString(JsonObject& obj, char* key);
    double getDouble(JsonObject& obj, char* key);
    JsonObject& getObject(JsonObject& obj, char* key);
    JsonArray& getArray(JsonObject& obj, char* key);
private:

};
