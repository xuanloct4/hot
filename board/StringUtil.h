#if ARDUINO >= 100
#include "Arduino.h"
#else
#include "WProgram.h"
#endif

#include <ArduinoJson.h>

class StringUtil {
public:
    StringUtil();
    JsonObject& jsonFromString(String jsonText);
    String stringFromJson(JsonObject& json);
    char* convertToChar(String text);
    String convertCharToString(char* chArray);
    boolean isNullOrEmpty(String text);
private:

};
