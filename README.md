# Plagiarism-Checker

A utility to check if a document's contents are plagiarised.

## How it works

*   It searches online using Google Search API's for some queries. Queries are n-grams extracted from the source txt file.
*   Resulting URL, matched contents are checked for similarity with given text query.
*   Result of average similarity of all URL's is stored in output text file.

## Required Libraries
The project uses python-docx module to decode docx files. The python-docx module has its own set of dependent libraries. The required libraries are:

*   PIL
*   lxml
*   python-dateutil
*   python-docx

### GETTING LIBRARIES ON LINUX

* Get easy_install

```bash
sudo apt-get install python-setuptools
```
* Install PIP

```bash
sudo easy_install pip
```
* Install dependent libraries

```bash
sudo pip install PIL

sudo pip install lxml

sudo pip install python-dateutil
```

* Install python-docx

```bash
sudo pip install docx
```

* Install pdftotext for pdf support (sketchy at the moment)

```bash
sudo apt-get install poppler-utils
```

* Get ppt and doc support

```bash
sudo apt-get install catdoc
```

### GETTING LIBRARIES ON WINDOWS

These steps assume you already have python installed and that python is in your windows environment variables.

Download [setup-tools](http://pypi.python.org/pypi/setuptools) according to your python version. (That is python 2.7 in most cases)

Run the .exe file. The installer will automatically find your python installation location from the registry and install easy_install to the Scripts directory where your python installation is located.

Once the installer has run, add easy_install to the windows environment variables path.

* Open a command window
* Run the following command:

```bash
easy_install pip
```
* Then install the required libraries for docx support

```bash
pip install PIL

pip install lxml

pip install python-dateutil

pip install docx
```

* EXEs for pdf, ppt and doc support are included in the package. Nothing need be installed.

## Folder Structure

*   assets/

Holds Twitter Bootstrap CSS and Javascript files and images/glyphicons

*   config/

Stores configuration data (Path to Python on Windows)

*   scripts/

Contains python scripts to perform plagiarism checks

*   temp/

Contains uploaded files

## Python Scripts

Backend is supported using python. There are 3 scripts in total.

*   scripts/main.py

Main script which gets the results of plagiarism

*   scripts/htmlstrip.py

Used to strip text from HTML tags

*   scripts/cosineSim.py

Helper modules to find cosine similarity between strings

## Usage of Python Script (Standalone)

```bash
python main.py sampleText.txt sampleOut.txt
```
