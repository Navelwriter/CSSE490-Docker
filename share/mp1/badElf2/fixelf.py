import lief

#ELF
binary = lief.parse("/share/mp1/badElf2/badelf2")
header = binary.header
#header.entrypoint = 0x10170
#change the program header size 
header.header_size = 0x34
header.identity_data = lief.ELF.ELF_DATA.LSB
binary.write('goodelf')
