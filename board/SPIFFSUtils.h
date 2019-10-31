
#if ARDUINO >= 100
#include "Arduino.h"
#else
#include "WProgram.h"
#endif

#include <FS.h>


class SPIFFSUtils {
public:
    SPIFFSUtils();
    bool writeFile(String url, String content);
    String readFile(String url);
    ~SPIFFSUtils();
private:
    
};
