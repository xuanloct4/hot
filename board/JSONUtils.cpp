#include "JSONUtils.h"

JSONUtils::JSONUtils() {
}

JSONUtils::~JSONUtils() {
}

long JSONUtils::getLong(JsonObject& obj, char* key) {
       if ((obj != JsonObject::invalid()) && containsNestedKey(obj, key)) {
            return obj[key].as<long>();
        }
        return defaultNotFound;
}

int JSONUtils::getInteger(JsonObject& obj, char* key) {
       if ((obj != JsonObject::invalid()) && containsNestedKey(obj, key)) {
            return obj[key].as<int>();
       }
        return defaultNotFound;
}

String JSONUtils::getString(JsonObject& obj, char* key) {
        if ((obj != JsonObject::invalid()) && containsNestedKey(obj, key)) {
            return obj[key].as<String>();
        }
        return "";
}

double JSONUtils::getDouble(JsonObject& obj, char* key) {
        if ((obj != JsonObject::invalid()) && containsNestedKey(obj, key)) {
            return obj[key].as<double>();
        }
    return defaultNotFound;
}

JsonObject& JSONUtils::getObject(JsonObject& obj, char* key) {
    if ((obj != JsonObject::invalid()) && containsNestedKey(obj, key)) {
        return obj[key].as<JsonObject>();
      }
    return createJSONObject(jb);
}

JsonArray& JSONUtils::getArray(JsonObject& obj, char* key) {
   if ((obj != JsonObject::invalid()) && containsNestedKey(obj, key)) {
        return obj[key].as<JsonArray>();
   }
    return createJSONArray(jb);
}

bool JSONUtils::containsNestedKey(JsonObject& obj, char* key) {
    for (const JsonPair& pair : obj) {
        if (!strcmp(pair.key, key))
            return true;

        if (containsNestedKey(pair.value.as<JsonObject>(), key))
            return true;
    }

    return false;
}

void JSONUtils::merge(JsonObject& dest, JsonObject& src) {
   for (auto kvp : src) {
     dest[kvp.key] = kvp.value;
   }
}

JsonObject& JSONUtils::createJSONObject(DynamicJsonBuffer& jb) {
    JsonObject& jo = jb.createObject();
    return jo;
}

JsonArray& JSONUtils::createJSONArray(DynamicJsonBuffer& jb) {
    JsonArray& ja = jb.createArray();
    return ja;
}

// This function works with JsonVariant(prototype) are JsonObject and JsonArray
JsonVariant JSONUtils::clone(DynamicJsonBuffer& jb, JsonVariant prototype) {

  if (prototype.is<JsonObject>()) {
    const JsonObject& protoObj = prototype;
    JsonObject& newObj = jb.createObject();
    for (const auto& kvp : protoObj) {
      newObj[jb.strdup(kvp.key)] = clone(jb, kvp.value);
    }
    return newObj;
  }

  if (prototype.is<JsonArray>()) {
    const JsonArray& protoArr = prototype;
    JsonArray& newArr = jb.createArray();
    for (const auto& elem : protoArr) {
      newArr.add(clone(jb, elem));
    }
    return newArr;
  }

  if (prototype.is<char*>()) {
    return jb.strdup(prototype.as<const char*>());
  }

  return prototype;
}
