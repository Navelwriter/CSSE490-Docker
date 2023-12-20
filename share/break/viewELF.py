import lief

binary = lief.parse("./breakme")
header = binary.header
print(binary)
