#include "DateTimeUtils.h"

DateTimeUtils::DateTimeUtils() {
  dateTimeFormat = DATE_TIME_STANDARD_FORMAT;
}

DateTimeUtils::~DateTimeUtils() {
  
}

void DateTimeUtils::test() 
{
//void    setTime(time_t t);
//void    setTime(int hr,int min,int sec,int day, int month, int yr);
//void    adjustTime(long adjustment);
//char* monthStr(uint8_t month);
//char* dayStr(uint8_t day);
//char* monthShortStr(uint8_t month);
//char* dayShortStr(uint8_t day);
  
/* time sync functions  */
//timeStatus_t timeStatus(); // indicates if time has been set and recently synchronized
//void    setSyncProvider( getExternalTime getTimeFunction); // identify the external time provider
//void    setSyncInterval(time_t interval); // set the number of seconds between re-sync

/* low level functions to convert to and from system time                     */
//void breakTime(time_t time, tmElements_t &tm);  // break time_t into elements
//time_t makeTime(const tmElements_t &tm);  // convert time elements into time_t
 
  setTime(14, 3, 5, 25, 11, 2019);
  Serial.println(currentSettingString());
   Serial.println(timeInterval("2019-1-3 14:05:3"));
}

void DateTimeUtils::setDateTimeFormat(String format)
{
  char c_format[sizeof(format)];
  format.toCharArray(c_format, sizeof(c_format));
  dateTimeFormat = c_format;
}

String DateTimeUtils::getDateTimeFormat()
{
  String str(dateTimeFormat);
  return str;
}

tmElements_t DateTimeUtils::timeComponentFromString(String str)
{
 createElements(str);
 return tm;
}

time_t DateTimeUtils::timeInterval(String str)
{
 time_t timeInt = makeTime(timeComponentFromString(str));
// Serial.print("Time interval from ");Serial.print(str);Serial.print(" is: ");Serial.println(timeInt);
 return timeInt;
}

String DateTimeUtils::timeString(int year, int month, int day, int hour, int minute, int second)
{
 char* timeString = new char[32];
 sprintf(timeString, dateTimeFormat, year,month,day,hour,minute,second);
 String str(timeString);
 return str;
}

String DateTimeUtils::currentSettingString()
{
 time_t t = now(); // Store the current time in time variable t
  return timeStringFromInterval(t);
}

String DateTimeUtils::timeStringFromInterval(time_t timeInt)
{
 Serial.print("The current time is: ");Serial.println(timeInt);
  int s = second(timeInt); // Returns the second for the given time t
  int m = minute(timeInt); // Returns the minute for the given time t
 int HH = hour(timeInt); // Returns the hour for the given time t
 int h =  hourFormat12(timeInt); // the hour for the given time in 12 hour format
 boolean isAm = isAM(timeInt);    // returns true the given time is AM
 boolean isPm =  isPM(timeInt);    // returns true the given time is PM
 int d = day(timeInt); // The day for the given time t
 int wd = weekday(timeInt); // Day of the week for the given time t
 int M = month(timeInt); // The month for the given time t
 int Y = year(timeInt); // The year for the given time t

// Serial.println("The component is: ");
// Serial.print("Second: ");Serial.println(s);
// Serial.print("Minute: ");Serial.println(m);
// Serial.print("24_H_FORMAT: ");Serial.println(HH);
// Serial.print("12_H_FORMAT: ");Serial.println(h);
// Serial.print("AM: ");Serial.println(isAm);
// Serial.print("PM: ");Serial.println(isPm);
// Serial.print("Day: ");Serial.println(d);
// Serial.print("Day of week: "); Serial.println(wd);
// Serial.print("Month: ");Serial.println(M);
// Serial.print("Year: ");Serial.println(Y);
  String str = timeString(Y,M,d,HH,m,s);
 return str;
}

void DateTimeUtils::createElements(String str)
{
  char c_text[sizeof(str)];
  str.toCharArray(c_text, sizeof(c_text));
  sscanf(c_text, dateTimeFormat, &Year, &Month, &Day, &Hour, &Minute, &Second);
  tm.Year = CalendarYrToTm(Year);
  tm.Month = Month;
  tm.Day = Day;
  tm.Hour = Hour;
  tm.Minute = Minute;
  tm.Second = Second;
}

long DateTimeUtils::timeDifference(char* firstDateTime, char* secondDateTime)
{
//  Serial.println("format is yyyy-mm-dd hh:mm:ss");
//  char firstDateTime[] = {"2017-03-26 10:30:15"};
//  char secondDateTime[] = {"2017-03-27 10:30:15"};
  createElements(firstDateTime);
  unsigned long firstTime = makeTime(tm);
  createElements(secondDateTime);
  unsigned long secondTime = makeTime(tm);
  long diff = secondTime - firstTime;
  Serial.print("Time Difference between ");Serial.print(firstDateTime); Serial.print(" and ");Serial.print(secondDateTime);Serial.print(" is: ");Serial.print(diff);Serial.println("(s)");
  return diff;
}
