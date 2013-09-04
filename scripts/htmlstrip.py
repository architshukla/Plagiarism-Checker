#script to strip given text from HTML tags
#usecase: Content from webpages recovered may have stray HTML tags, like <b> or <i>

from HTMLParser import HTMLParser

#Simple class to encapsulate the stripping of html tags.
class MLStripper(HTMLParser):
    def __init__(self):
        self.reset()
        self.fed = []
    def handle_data(self, d):
        self.fed.append(d)
    def get_data(self):
        return ''.join(self.fed)

#module to strip tags.
#uses the MLStripper class
def strip_tags(html):
    s = MLStripper()
    s.feed(html)
    return s.get_data()
