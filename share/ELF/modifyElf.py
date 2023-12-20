import lief

#ELF
binary = lief.parse("/share/badelf")
header = binary.header
header.machine_type = lief.ELF.ARCH.ARM
header.entrypoint = 0x1030c
binary.write('goodelf')
