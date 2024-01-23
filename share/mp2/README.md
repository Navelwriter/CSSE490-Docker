# MP2
## Completed by Noah Lee

Analyze sample01 in ghidra and answer the following questions.

####  1. What is the text section offset of the main function? (1 point) 
The text section offset of the main function can be found with the address of the main subtracted by the entry: 00010d10 - 000107bc = 0000554.
This is assuming that "entry" is not the main function, but calls the main function within it.
####  2. What does the `FUN\_00010bf4` function do? (3 points) 
It seems this functions acts as a client that connects to a specific server, sends the command REQCMD, recieves a response and copies it to the memory provided in the parameter for the caller to use. 
#### 3. `FUN\_00101b64` processes an array. What are the elements of the array that it processes? (Hint: a for loop is used, look for the loop index.) (3 points) 
The loop exits after the index variable reaches 5, meaning that there are 5 elements in array. It seems to be an array of character buffers and it compares this to the global array to compare to using strncmp. The array in question is an array of names that is compared to the response to the server. Which is jerry, elaine, george, kramer, frank, estelle.
####  4. The program eventually runs one of a few command subroutines, how many are there? (3 points)
The main function (FUN_00010d10) does a variety of things, including recieving a char buffer after connecting to a server. This buffer is used to get an index, which is used to choose an element in DAT_000220a0 (I renamed to FunctionList). Within Functionlist are 6 functions, selected to run by the index mentioned earlier. 
####  5. What is the command provided to the program that will cause the program to exit with nonzero status? (5 points)
In FUN_00101b64 (renamed to searchArray), we need this to return 1 to call the 2nd function in FunctionList to return 1. In order for this to happen, we need the server to respond with a string that matches index 1 of the Array. Looking at DAT_00022084 (renamed to Array), you can see that the element at index 1 is "elaine." Therefore providing the name "elaine" will cause the program to exit with code 1.
####  6. What are the other command routines and what do they do? (10 points)
  ##### FunctionList (originally DAT_000220a0)
- writeBashrc (FUN_00010a0c)
    - This function opens the .bashrc file that runs bash commands on startup. It mostly just adds echo functions to print out some things like "you are in a room with ...". Very spooky
- exit_1 (FUN_00010a8c)
    - The sole use of this function is to exit with code 1.
- returnInt (LAB_00010a9c)
    - In the entry point, FUN_00010d10 is called with two parameters, the second of which is a pointer to the stack to write to. In this function, the global variable DAT_000220bc is assigned to the value at memory location of the paramter + 4. DAT_000220bc is used in returnInt and simply returns this global value as an integer.
- killOtherProcesses (FUN_00010ac0)
    - killOtherProcesses gets the current pid number and kills all other processes that do not share the same pid number. Returns the last process killed. 
- fork (LAB_00010b28)
    - It seems like this function just forks processes infinitely
- returnPass (FUN_00010b38)
    - This function returns the data stored in /etc/passwd. Which is the password :) Not very good...

####  7. What type of malware would you classify this sample as? (2 points) 
  This seems to be some sort of network-connected command and control. It seems to connect to a server, recieve a user, and if the user matches one of the names in a list, it performs different function. For example: If the server returns "jerry", it will write some echo commands to bashrc, and if it returns "estelle", it sends the password to the server. In order to have access to these files, this must have root access. 
