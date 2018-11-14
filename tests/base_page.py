class Page(object):
    "Page class that all page models can inherit from"
 
    def __init__(self,selenium_driver,base_url='http://silatorre.000webhostapp.com/'):
        "Constructor"
        #We assume relative URLs start without a / in the beginning
        if base_url[-1] != '/': 
            base_url += '/' 
        self.base_url = base_url
        self.driver = selenium_driver 
 
    def open(self,url):
        "Visit the page base_url + url"
        url = self.base_url + url
        self.driver.get(url)
 