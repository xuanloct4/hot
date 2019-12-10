#!/usr/bin/env bash
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
ARDUINO_TOOLS_MKSPIFFS=${ARDUINO_PACKAGES}/esp8266/tools/mkspiffs/0.2.0;
ARDUINO_TOOLS_XTENSA_ELF_GCC=${ARDUINO_PACKAGES}/esp8266/tools/xtensa-lx106-elf-gcc/1.20.0-26-gb404fb9-2;
ARDUINO_TOOLS_ESPTOOL=${ARDUINO_PACKAGES}/esp8266/tools/esptool/0.4.13;
ARDUINO_TOOLS_BUILDER="/Applications/Arduino-1.8.10.app/Contents/Java/tools-builder";
ARDUINO_HARDWARE_TOOLS_AVR=${ARDUINO_HARDWARE}/tools/avr;
ARDUINO_BUILT_IN_LIBRARIES="/Applications/Arduino-1.8.10.app/Contents/Java/libraries";
FQBN="esp8266:esp8266:nodemcuv2:CpuFrequency=80,VTable=flash,FlashSize=4M1M,LwIPVariant=v2mss536,Debug=Disabled,DebugLevel=None____,FlashErase=none,UploadSpeed=115200";
PREF="-prefs=build.warn_data_percentage=75"" -prefs=runtime.tools.mkspiffs.path="${ARDUINO_TOOLS_MKSPIFFS}" -prefs=runtime.tools.mkspiffs-0.2.0.path="${ARDUINO_TOOLS_MKSPIFFS}" -prefs=runtime.tools.xtensa-lx106-elf-gcc.path="${ARDUINO_TOOLS_XTENSA_ELF_GCC}" -prefs=runtime.tools.xtensa-lx106-elf-gcc-1.20.0-26-gb404fb9-2.path="${ARDUINO_TOOLS_XTENSA_ELF_GCC}" -prefs=runtime.tools.esptool.path="${ARDUINO_TOOLS_ESPTOOL}" -prefs=runtime.tools.esptool-0.4.13.path="${ARDUINO_TOOLS_ESPTOOL};

#echo ${PREF};
