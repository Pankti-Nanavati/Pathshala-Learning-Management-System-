#!/usr/bin/env python
import random

 
# defining function for random
# string id with parameter
def ran_gen():
    chars="abcdefghijklmnopqrstuvwxyz0123456789"
    return ''.join(random.choice(chars) for x in range(6))
 
print(ran_gen())

