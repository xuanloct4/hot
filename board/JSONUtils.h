
#if ARDUINO >= 100
#include "Arduino.h"
#else
#include "WProgram.h"
#endif

#include <ArduinoJson.h>

class JSONUtils{
public:
    JSONUtils();
    bool containsNestedKey(JsonObject& obj, char* key);
    void merge(JsonObject& dest, JsonObject& src);
    JsonVariant clone(DynamicJsonBuffer& jb, JsonVariant prototype);
    JsonObject& createJSONObject(DynamicJsonBuffer& jb);
    JsonArray& createJSONArray(DynamicJsonBuffer& jb);
private:
    
};
