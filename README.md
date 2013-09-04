Plagiarism-Checker
==================

A utility to check if a document's contents are plagiarised.

How it works
-------------

* It searches online using Google Search API's for some queries. Queries are n-grams extracted from the source txt file. 
* Resulting URL, matched contents are checked for similarity with given text query.
* Result of average similarity of all URL's is stored in output text file.

Folder Structure
----------------

* assets/

Holds Twitter Bootstrap CSS and Javascript files and images/glyphicons

* config/

Stores configuration data (Path to Python on Windows)

* scripts/

Contains python scripts to perform plagiarism checks

* temp/

Contains uploaded files

Python Scripts
---------------

Backend is supported using python. There are 3 scripts in total.

1. scripts/main.py

Main script which gets the results of plagiarism

2. scripts/htmlstrip.py

Used to strip text from HTML tags

3. scripts/cosineSim.py

Helper modules to find cosine similarity between strings

Usage of Python Script (Standalone)
------------------------------------

> python main.py sampleText.txt sampleOut.txt

