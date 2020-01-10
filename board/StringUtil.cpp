#include "StringUtil.h"

StringUtil::StringUtil() {
}

JsonObject& StringUtil::jsonFromString(String jsonText) {
    DynamicJsonBuffer jsonBuffer;

    // You can use a String as your JSON input.
    // WARNING: the content of the String will be duplicated in the JsonBuffer.
    JsonObject& jsonObj = jsonBuffer.parseObject(jsonText);
    //// using C++11 syntax (preferred):
    //for (auto kv : jsonObj) {
    //    Serial.println(kv.key);
    //    Serial.println(kv.value.as<char*>());
    //}
    //
    //// using C++98 syntax (for older compilers):
    //for (JsonObject::iterator it=jsonObj.begin(); it!=jsonObj.end(); ++it) {
    //    Serial.println(it->key);
    //    Serial.println(it->value.as<char*>());
    //}

    return jsonObj;
}

String StringUtil::stringFromJson(JsonObject& json) {
    String text;
    json.printTo(text);
    return text;
}

char* StringUtil::convertToChar(String text) {
//    int str_len = text.length() + 1; 
//    char c_text[str_len];
//    text.toCharArray(c_text, str_len);
//    return c_text;
    return (char*)text.c_str();
}


String StringUtil::convertCharToString(char* chArray) {
    String str(chArray);
    return str;
}

boolean StringUtil::isNullOrEmpty(String text) {
    if (!text) {
        return true;
    } else {
        text.trim();
        if (text.length() == 0) {
            return true;
        } else {
            return false;
        }
    }
}
