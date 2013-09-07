# -*- coding: utf-8 -*-

#import other modules
from cosineSim import *
from htmlstrip import *

#import required modules
import codecs
import sys
import operator
import urllib, urllib2
import json as simplejson

# Given a text string, remove all non-alphanumeric
# characters (using Unicode definition of alphanumeric).
def getQueries(text,n):
	import re
	sentenceEnders = re.compile('[.!?]')
	sentenceList = sentenceEnders.split(text)
	sentencesplits = []
	for sentence in sentenceList:
		x = re.compile(r'\W+', re.UNICODE).split(sentence)
		x = [ele for ele in x if ele != '']
		sentencesplits.append(x)
	finalq = []
	for sentence in sentencesplits:
		l = len(sentence)
		l=l/n
		index = 0
		for i in range(0,l):
			finalq.append(sentence[index:index+n])
			index = index + n-1
		if index !=len(sentence):
			finalq.append(sentence[len(sentence)-index:len(sentence)])
	return finalq

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
		for ele in	results['responseData']['results']:		  
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
	return output,c

# Use the main function to scrutinize a file for
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
	queries = getQueries(t,n)
	q = [' '.join(d) for d in queries]
	found = []
	#using 2 dictionaries: c and output
	#output is used to store the url as key and number of occurences of that url in different searches as value
	#c is used to store url as key and sum of all the cosine similarities of all matches as value	
	output = {}
	c = {}
	i=1
	count = len(q)
	for s in q:
		output,c=searchWeb(s,output,c,encode=True)
		msg = "\r"+str(i)+"/"+str(count)+"completed..."
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
