# RE_me

RE_me is a stripped ARM binary, analyze that binary in ghidra.

1. Function Analysis: Identify and describe the purpose of each function called by main. Rename those function to sane names
There are the following (renamed) functions called from entry/main:
    - take_input: This prompts the user for data, adds them, checks for admin
    - Function array: This takes in multiple functions and iterates through it?
    - add: This takes two integers and returns the sum
2. Variable Analysis: Walk through and give the variables sane names 
Example \
```c
undefined4 take_input(void)

{
  size_t string;
  undefined4 sum;
  int verification;
  undefined4 num2;
  undefined4 num1;
  char charBuffer [52];
  
  printf("Enter your name: ");
  fgets(charBuffer,0x32,stdin);
  string = strcspn(charBuffer,"\n");
  charBuffer[string] = '\0';
  nameGreeting(charBuffer);
  printf("Enter two numbers to add: ");
  __isoc99_scanf("%d %d",&num1,&num2);
  sum = add(num1,num2);
  printf("The sum of %d and %d is %d\n",num1,num2,sum);
  verification = strcmp(charBuffer,"admin");
  if (verification == 0) {
    puts("Welcome back, admin!");
  }
  else {
    puts("You are not the admin.");
  }
  return 0;
```
3. String Manipulation: There is some stuff going on with the newline character
   after the call to fgets? What is being done? Why is this necessary?
    - strcspn checks number of characters until the specified char is found. In this case, it is looking if there is a \n new line at the end, which would mean that the user pressed enter.
4. Control Flow Analysis: What is the purpose of the conditional check involving the strcmp function? How does the program behave differently for different inputs?
    - Basically it just checks whether the name is admin or not
5. Parameter Passing: What do you expect this program to read from stdin?
    - Probably just keyboard input
6. Memory Analysis: Investigate how the user's name and the input numbers are stored in memory. What can you infer about stack usage in this program?
    - These are stored on the stack a byte apart from each other. They are sequencially stored is my guess. 
7. Debugging Practice: If you modify the input string to an excessively long sequence of characters, what happens? Why does this occur, and how could it be prevented?
    -

# RE_me2 

Here's another ARM binary. This one has a little more control flow going on,
even though it is not stripped.  What vulnerability does it contain (hint: not a
buffer overflow)?

Bonus: can you get this program to output its secret? Note: there is no win
funct ion to call for this one. Hint: remember calling conventions and stack layouts. A debugger can be quite useful here.
