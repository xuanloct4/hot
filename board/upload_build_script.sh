#!/usr/bin/env bash
#/bin/bash

. $(dirname "$0")/build_env.sh

${ARDUINO_BUILDER} -dump-prefs -logger=machine -hardware ${ARDUINO_HARDWARE} -hardware ${ARDUINO_PACKAGES} -tools ${ARDUINO_TOOLS_BUILDER} -tools ${ARDUINO_HARDWARE_TOOLS_AVR} -tools ${ARDUINO_PACKAGES} -built-in-libraries ${ARDUINO_BUILT_IN_LIBRARIES} -libraries ${SKETCH_LIBRARIES} -fqbn=${FQBN} -ide-version=10810 -build-path ${BUILD_PATH} -warnings=none -build-cache ${BUILD_CACHE} ${PREF} -verbose ${FilePath}
${ARDUINO_BUILDER} -compile -logger=machine -hardware ${ARDUINO_HARDWARE} -hardware ${ARDUINO_PACKAGES} -tools ${ARDUINO_TOOLS_BUILDER} -tools ${ARDUINO_HARDWARE_TOOLS_AVR} -tools ${ARDUINO_PACKAGES} -built-in-libraries ${ARDUINO_BUILT_IN_LIBRARIES} -libraries ${SKETCH_LIBRARIES} -fqbn=${FQBN} -ide-version=10810 -build-path ${BUILD_PATH} -warnings=none -build-cache ${BUILD_CACHE} ${PREF} -verbose ${FilePath}

${ARDUINO_PACKAGES}/esp8266/tools/esptool/0.4.13/esptool -vv -cd nodemcu -cb 115200 -cp /dev/cu.wchusbserial1410 -ca 0x00000 -cf ${BIN_OUTPUT_FILE}

#screen /dev/cu.wchusbserial1410 115200

