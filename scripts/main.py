# -*- coding: utf-8 -*-

#import other modules
from cosineSim import *
from htmlstrip import *

#import required modules
import codecs
import sys
import operator
import urllib, urllib2, simplejson

# Given a text string, remove all non-alphanumeric
# characters (using Unicode definition of alphanumeric).
def stripNonAlphaNum(text):
    import re
    return re.compile(r'\W+', re.UNICODE).split(text)

# Given a list of words and a number n, return a list
# of n-grams.
def getNGrams(wordlist, n):
    return [wordlist[i:i+n] for i in range(len(wordlist)-(n-1))]

# Query Google if a given string, preferably a sentence (min. 8 words?),
# is plagiarized (copied literally) from an available web source.
# The 'encode' flag can be used if the given string is a Unicode (UTF-8)
# string.
def searchWeb(text,output,c,encode=False):
    if encode == True:
        text = text.encode('utf-8')
    query = urllib.quote_plus(text)
    #using googleapis for searching web
    base_url = 'http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q='
    url = base_url + '%22' + query + '%22'
    request = urllib2.Request(url,None,{'Referer':'http://www.rvce.edu.in'})
    response = urllib2.urlopen(request)
    results = simplejson.load(response)
    if results['responseData']['results'] and results['responseData']['results'] != []:
	for ele in  results['responseData']['results']:       
		Match = results['responseData']['results'][0]
		content = Match['content']
		if Match['url'] in output:
			#print text
			#print strip_tags(content)
        		output[Match['url']] = output[Match['url']] + 1
			c[Match['url']] = (c[Match['url']]*(output[Match['url']] - 1) + cosineSim(text,strip_tags(content)))/(output[Match['url']])
		else:
			output[Match['url']] = 1
			c[Match['url']] = cosineSim(text,strip_tags(content))
		#print cosineSim(text,strip_tags(content))		
		#print "\n"
    return output,c

# Use the GPlag() function to scrutinize a file for
# plagiarism
def main():
    # n-grams N VALUE SET HERE
    n=9
    if len(sys.argv) <3:
	print "Usage: python main.py <input-filename>.txt <output-filename>.txt"
	sys.exit()
    t=codecs.open(sys.argv[1],'r','utf-8')
    if not t:
	print "Invalid Filename"
	print "Usage: python main.py <input-filename>.txt <output-filename>.txt"
	sys.exit()
    t=t.read()
    ngrams = getNGrams(stripNonAlphaNum(t),n)
    n = [' '.join(d) for d in ngrams]
    found = []
    #using 2 dictionaries: c and output
    #output is used to store the url as key and number of occurences of that url in different searches as value
    #c is used to store url as key and sum of all the cosine similarities of all matches as value	
    output = {}
    c = {}
    i=1
    for s in n[:15]:
        output,c=searchWeb(s,output,c,encode=True)
        msg = "\r"+str(i)+"/15 completed..."
        sys.stdout.write(msg);
        sys.stdout.flush()
        i=i+1
    #print "\n"
    f = open(sys.argv[2],"w")
    for ele in sorted(c.iteritems(),key=operator.itemgetter(1),reverse=True):
	f.write(str(ele[0])+" "+str(ele[1]*100.00))
	f.write("\n")
    f.close()
    print "\nDone!"


if __name__ == "__main__":
	main()
