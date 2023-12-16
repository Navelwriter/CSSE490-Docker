import lief

#ELF
binary = lief.parse("~/home/CSSE490/CSSE490-Docker/share/badelf")
print(binary)
