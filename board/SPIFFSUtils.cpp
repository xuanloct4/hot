#include "SPIFFSUtils.h"

SPIFFSUtils::SPIFFSUtils() {
    //  stringUtil = new StringUtil();
}

SPIFFSUtils::~SPIFFSUtils() {
    //   delete(stringUtil);
}

bool SPIFFSUtils::writeFile(String url, String content) {
    if (!SPIFFS.begin())
    {
        Serial.println("Failed to mount the file system");
        return false;
    }
    
    Serial.print("Opening for Writing: ");
    Serial.println(url);
    File file = SPIFFS.open(url, "w");
    if (!file) {
        Serial.println(" Failed!");
        return false;
    }
    
    if(file.print(content) != 0) {
        Serial.println("File was written");
        file.close();
        return true;
    }else {
        Serial.println("File write failed");
        file.close();
        return false;
    }
}

String SPIFFSUtils::readFile(String url) {
    if (!SPIFFS.begin())
    {
        Serial.println("Failed to mount the file system");
        return "";
    }
    Serial.print("Opening for Reading: ");
    Serial.println(url);
    File file = SPIFFS.open(url, "r");
    if(!file){
        Serial.println("Failed to open file for reading");
        return "";
    }
    
    Serial.println("File Content:");
    String content;
    while(file.available()){
        content = file.readString();
        //         Serial.write(file.read());
    }
    file.close();
    return content;
}
