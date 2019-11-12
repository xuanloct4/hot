#/bin/bash

FileName="board.ino";
FileDir="/Library/WebServer/Documents/hot/board";
FilePath=${FileDir}/;
FilePath=${FilePath}board.ino;

BUILD_PATH="/Library/WebServer/Documents/hot/board/build";
BUILD_CACHE=${BUILD_PATH}/cache;
SKETCH_LIBRARIES="/Users/loctv/Documents/Arduino/sketch/libraries";
BIN_OUTPUT_FILE=${BUILD_PATH}/;
BIN_OUTPUT_FILE=${BIN_OUTPUT_FILE}${FileName}.bin;

ARDUINO_BUILDER="/Applications/Arduino-1.8.10.app/Contents/Java/arduino-builder";
ARDUINO_HARDWARE="/Applications/Arduino-1.8.10.app/Contents/Java/hardware";
ARDUINO_PACKAGES="/Users/loctv/Library/Arduino15/packages";
ARDUINO_TOOLS_BUILDER="/Applications/Arduino-1.8.10.app/Contents/Java/tools-builder";
ARDUINO_HARDWARE_TOOLS_AVR=${ARDUINO_HARDWARE}/tools/avr;
ARDUINO_BUILT_IN_LIBRARIES="/Applications/Arduino-1.8.10.app/Contents/Java/libraries";
FQBN="esp8266:esp8266:nodemcuv2:CpuFrequency=80,VTable=flash,FlashSize=4M1M,LwIPVariant=v2mss536,Debug=Disabled,DebugLevel=None____,FlashErase=none,UploadSpeed=115200";

echo ${BIN_OUTPUT_FILE};

${ARDUINO_BUILDER} -dump-prefs -logger=machine -hardware ${ARDUINO_HARDWARE} -hardware ${ARDUINO_PACKAGES} -tools ${ARDUINO_TOOLS_BUILDER} -tools ${ARDUINO_HARDWARE_TOOLS_AVR} -tools ${ARDUINO_PACKAGES} -built-in-libraries ${ARDUINO_BUILT_IN_LIBRARIES} -libraries ${SKETCH_LIBRARIES} -fqbn=${FQBN} -ide-version=10810 -build-path ${BUILD_PATH} -warnings=none -build-cache ${BUILD_CACHE} -prefs=build.warn_data_percentage=75 -prefs=runtime.tools.mkspiffs.path=${ARDUINO_PACKAGES}/esp8266/tools/mkspiffs/0.2.0 -prefs=runtime.tools.mkspiffs-0.2.0.path=${ARDUINO_PACKAGES}/esp8266/tools/mkspiffs/0.2.0 -prefs=runtime.tools.xtensa-lx106-elf-gcc.path=${ARDUINO_PACKAGES}/esp8266/tools/xtensa-lx106-elf-gcc/1.20.0-26-gb404fb9-2 -prefs=runtime.tools.xtensa-lx106-elf-gcc-1.20.0-26-gb404fb9-2.path=${ARDUINO_PACKAGES}/esp8266/tools/xtensa-lx106-elf-gcc/1.20.0-26-gb404fb9-2 -prefs=runtime.tools.esptool.path=${ARDUINO_PACKAGES}/esp8266/tools/esptool/0.4.13 -prefs=runtime.tools.esptool-0.4.13.path=${ARDUINO_PACKAGES}/esp8266/tools/esptool/0.4.13 -verbose ${FilePath}

${ARDUINO_BUILDER} -compile -logger=machine -hardware ${ARDUINO_HARDWARE} -hardware ${ARDUINO_PACKAGES} -tools ${ARDUINO_TOOLS_BUILDER} -tools ${ARDUINO_HARDWARE_TOOLS_AVR} -tools ${ARDUINO_PACKAGES} -built-in-libraries ${ARDUINO_BUILT_IN_LIBRARIES} -libraries ${SKETCH_LIBRARIES} -fqbn=${FQBN} -ide-version=10810 -build-path ${BUILD_PATH} -warnings=none -build-cache ${BUILD_CACHE} -prefs=build.warn_data_percentage=75 -prefs=runtime.tools.mkspiffs.path=${ARDUINO_PACKAGES}/esp8266/tools/mkspiffs/0.2.0 -prefs=runtime.tools.mkspiffs-0.2.0.path=${ARDUINO_PACKAGES}/esp8266/tools/mkspiffs/0.2.0 -prefs=runtime.tools.xtensa-lx106-elf-gcc.path=${ARDUINO_PACKAGES}/esp8266/tools/xtensa-lx106-elf-gcc/1.20.0-26-gb404fb9-2 -prefs=runtime.tools.xtensa-lx106-elf-gcc-1.20.0-26-gb404fb9-2.path=${ARDUINO_PACKAGES}/esp8266/tools/xtensa-lx106-elf-gcc/1.20.0-26-gb404fb9-2 -prefs=runtime.tools.esptool.path=${ARDUINO_PACKAGES}/esp8266/tools/esptool/0.4.13 -prefs=runtime.tools.esptool-0.4.13.path=${ARDUINO_PACKAGES}/esp8266/tools/esptool/0.4.13 -verbose ${FilePath}

${ARDUINO_PACKAGES}/esp8266/tools/esptool/0.4.13/esptool -vv -cd nodemcu -cb 115200 -cp /dev/cu.wchusbserial1410 -ca 0x00000 -cf ${BIN_OUTPUT_FILE}
