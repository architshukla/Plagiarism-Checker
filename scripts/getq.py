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

f = open("sampleText.txt","r")
text = f.read()
print len(text.split())
print len(getQueries(text,8))
