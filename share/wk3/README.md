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

DECIMAL |      HEXADECIMAL    | DESCRIPTION|
-------|---------|------|
0  |           0x0   |          DLOB firmware header, boot partition: "dev=/dev/mtdblock/1"|
10376    |     0x2888      |    LZMA compressed data, properties: 0x5D, dictionary size: 8388608 bytes, uncompressed size: 4942464 bytes|
1638512    |   0x190070   |     PackImg section delimiter tag, little endian size: 11565568 bytes; big endian size: 8040448 bytes|
1638544     |  0x190090  |      Squashfs filesystem, little endian, version 4.0, compression:lzma, size: 8036376 bytes, 2476 inodes, blocksize: 131072 bytes, created: 2016-05-27 03:37:47|

This tells us that the firmware image contains a boot partition, a compressed section, and a squashfs filesystem.

2. Extract the files from the 850.bin file. What type of device is this firmware for?
I extracted the files using binwalk -e 850.bin. This is a firmware for a router.
I can tell because there's a script called "getmodem" and has alot of other files that are related to a router.
3. Who is the manufacturer of the device?
The manufacturer is D-Link. This was found in the getmodem script.
4. What is the model name of the device?

5. There are a bunch of broken symlinks in /etc? Why are they broken? What might we expect the device to at boot time?

6. What is the default username and password for the device configuration interface (find this in the firmware image)?
