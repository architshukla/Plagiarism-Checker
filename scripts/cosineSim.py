#module to check cosine similarity of two strings

import re, math
from collections import Counter

WORD = re.compile(r'\w+')

#returns cosine similarity of two vectors
#input: two vectors
#output: integer between 0 and 1.
def get_cosine(vec1, vec2):
     intersection = set(vec1.keys()) & set(vec2.keys())

     #calculating numerator
     numerator = sum([vec1[x] * vec2[x] for x in intersection])

     #calculating denominator
     sum1 = sum([vec1[x]**2 for x in vec1.keys()])
     sum2 = sum([vec2[x]**2 for x in vec2.keys()])
     denominator = math.sqrt(sum1) * math.sqrt(sum2)

     #checking for divide by zero
     if denominator==0:
        return 0.0
     else:
        return float(numerator) / denominator

#converts given text into a vector
def text_to_vector(text):
     #uses the Regular expression above and gets all words
     words = WORD.findall(text)
     #returns a counter of all the words (count of number of occurences)
     return Counter(words)

#returns cosine similarity of two words
#uses: text_to_vector(text) and get_cosine(v1,v2)
def cosineSim(text1,text2):
     vector1 = text_to_vector(text1)
     vector2 = text_to_vector(text2)
     #print vector1,vector2	
     cosine = get_cosine(vector1, vector2)
     return cosine


