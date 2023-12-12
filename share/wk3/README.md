# Embedded System Firmware Basic Static Analysis Activity

There are many tools that can be used to analyze embedded system firmware. In this activity we will use the following tools:
    * `file` - determine the type of file
    * `strings` - extract strings from a binary file
    * `binwalk` - extract files from a binary file
    * `qemu-arm` - run an ARM binary on an x86 machine
    * `grep` - search for strings in a file
    * `find` - find files in a directory tree
    * `xxd` - display a binary file in hex
    * `objdump` - disassemble a binary file, display information about sections
    * `readelf` - display information about an ELF binary file
    * `nm` - display symbols in a binary file

## pass

There is binary called `pass` in the `bin` directory. It is a simple program that asks for a password and checks if it is correct. Can you find the correct password?

Verify by running the program with `qemu-arm` and entering the password.

## 850.bin

850.bin is a binary file that contains a firmware image. It is a firmware image for an embedded device.

1. What does binwalk find in the 850.bin file?

2. Extract the files from the 850.bin file. What type of device is this firmware for?

3. Who is the manufacturer of the device?

4. What is the model name of the device?

5. There are a bunch of broken symlinks in /etc? Why are they broken? What might we expect the device to at boot time?

6. What is the default username and password for the device configuration interface (find this in the firmware image)?
