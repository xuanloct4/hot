#if ARDUINO >= 100
#include "Arduino.h"
#else
#include "WProgram.h"
#endif

#include <ArduinoJson.h>
#include <TimeLib.h>
//#include "RestAPI.h"

#define DATE_TIME_STANDARD_FORMAT "%04d-%02d-%02d %02d:%02d:%02d"

class DateTimeUtils {
public:
    DateTimeUtils();
    ~DateTimeUtils();
    void setDateTimeFormat(String format);
    String getDateTimeFormat();
    void createElements(String str);
    long timeDifference(char* firstDateTime, char* secondDateTime);
    tmElements_t timeComponentFromString(String str);
    time_t timeInterval(String str);
    String timeString(int year, int month, int day, int hour, int minute, int second);
    String timeStringFromInterval(time_t timeInt);
    String currentSettingString();
    void test();
private:
    char *dateTimeFormat;
    tmElements_t tm;
    int Year, Month, Day, Hour, Minute, Second;
};
