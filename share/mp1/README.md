# MP1: Basic Analysis
### Completed by: Noah Lee

This assignment is designed to get you more experience with basic analysis of
embedded binaries.  Submit your answers as a pdf to moodle assignment page (if
you'd like, you can use pandoc to convert a markdown file to pdf).  This
assingment should be completed idividually.

## pass (5 points)

Answer the following questions using only `strings`, `objdump`, `readelf`, and `nm`.

1. What C standard library functions does the program use?

This program has many uses of the LIBC standard C library. This includes the usage of functions such as strcmp, fgets, puts, stdin, strtok, and abort.
2. This program requires a password to execute, what is that password and
  how did you find it? 

The password to the program was "hunter2"
I found this very easily by finding all the string values of the program using ` strings pass > ./Pass/strings.txt ` and looking at the strings outputted. This lead me to a very convenient string of "hunter2" after it prompts for the password. 
  

## badelf2 (10 points)

Everyone's favorite in-class activity is back - as homework.  Get this badelf to run and describe your changes (binary editing, include the script if you used python, etc...). This one is statically linked, so all you need is `qemu-arm badelf2`

Hint: there were two changes made to the ELF header.

There were two main problems with this: 

##### endianness: 
The badelf2 header indicated that the data was encoded using 2's complement w/ big endian. This was an issue as most arm programs are little endian, including all our previous binaries
##### architecture: 
When trying to run the program using qemu-arm, it would give an error "Invalid ELF image for this architecture" While the header was mostly correct, I started to look at things in lief documentation https://lief-project.github.io/doc/latest/api/python/elf.html . Particurally I saw that the header_size was set to 64, when it should be 40 for ELF32.

The python script used is as follows \
```
import lief
#ELF
binary = lief.parse("/share/mp1/badElf2/badelf2")
header = binary.header
#change the program header size
header.header_size = 0x34
header.identity_data = lief.ELF.ELF_DATA.LSB
binary.write('goodelf')
```
## overflow_me (20 points)

Answer the following questions using `strings`, `objdump`, `readelf`, `gdb`, `cyclic`, and `nm`.  For part 2, feel free to use a python script.

1. This program has a very basic buffer overflow vulnerability.  What is the
  vulnerability and how did you find it?  Refer to specific program output.
I began with first finding the optimal breakpoints. \
I did a `info functions` to get the accessable functions and set a `b vulnerable_function` as well as going through each instruction using `ni` \
From this, and putting in the large buffer of '123456789 112233445566778899' \
This is what I saw after running address 0x10478
![image](https://github.com/Navelwriter/CSSE490-Docker/assets/77686570/900d9a7d-2f8a-44ab-8bc3-06e1839498b7) \
With pc reflecting the input starting 20 characters after the beginning, it was clear that PC was getting overridden by the 4 bits following 20 characters ("6677")
With the buffer overflow even reaching the program counter, this means that we can potentially override PC with the address of any function we would want to execute.

3. What input will make the program execute the `win` function?  How did you
  find what that input should be?
Given the information about the input payload, there were a few parameters.
  - It takes 20 characters for PC to be overwritten
  -  The function I need to go to is `win`, which was located in 0001048c using my objdump to get the address.
  -  I need to do some sort of python script in order to encode my address, not just send random characters.

My python script is as follows.
```
#!/usr/bin/env python
from struct import pack
import sys
def packbuff(addr, padding = 20):
    payload = b''
    payload += b'\x00' * padding
    payload += pack('<I', addr)
    return payload

#this function takes in the input from the command line and adds it to a buffer
def main():
    address = int(sys.argv[1],16)
    payload = packbuff(address)
    sys.stdout.buffer.write(payload)

if __name__ == "__main__":
    main()
```
My first iteration of this, I simply outputted it out using print(payload), this did not work as it was just outputting it as simple chars.
![image](https://github.com/Navelwriter/CSSE490-Docker/assets/77686570/166c772e-6cbe-4f6f-8c6d-3fc075931c7d)
I figured out I had to use stdout to get it to output in the encoded format I wanted.
After this I could simply pipe this script into the program using `python3 packBuff.py 0x1048c | qemu-arm -g 1234 -L /usr/arm-linux-gnueabi ./overflow_me`
and it outputs `You win!`

Some things you might find helpful for overflow_me:
* Try large inputs and see what happens to `pc`
* The `finish` command in gdb
* `p32` function from pwntools or `struct.pack` from python's `struct` module
* Be sure to understand the difference between outputting encoded strings and raw bytes
