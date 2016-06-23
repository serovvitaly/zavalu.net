import urllib.request
import re
from pymongo import MongoClient

client = MongoClient('mongodb://localhost/alumico')
db = client.referat_kulichki_net
catalog = db.catalog

urls_arr = [
    'http://referat.kulichki.net/',
]

for page_url in urls_arr:
    with urllib.request.urlopen(page_url) as f:
        page_content = f.read().decode("windows-1251", "ignore")
        result = re.findall(r'<dt><a href="([^"]+)">([^<]*)</a>', page_content, re.MULTILINE)
        for category_mix in result:
            catalog.insert({
                'base_url': page_url,
                'href': category_mix[0],
                'title': category_mix[1],
            })
