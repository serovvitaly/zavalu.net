import datetime
import time
import urllib.error
import urllib.request
import re
import threading
from pymongo import MongoClient
import sys

"""основной хост для парсинга"""
HOST = 'https://referat.ru'


def get_page_content_by_url(url):
    url = HOST + url
    with urllib.request.urlopen(url) as f:
        try:
            content = f.read().decode("utf-8", "ignore")
            return content
        except urllib.error.HTTPError:
            print('ERROR')
            return None


client = MongoClient('mongodb://localhost/alumico')
db = client.referat_ru
catalog = db.catalog
documents = db.documents

docs_arr = documents.find({
    'download_link': {'$exists': False},
    'error': {'$exists': False}
}, no_cursor_timeout=True)


def do_parsing(doc, counter):
    docId = doc['_id']
    doc.pop("_id", None)
    print(str(counter) + '. ' + HOST + doc['url'])
    try:
        page_content = get_page_content_by_url(doc['url'])
        size_mcs = re.search(r'<li><span>Размер файла</span> (\d+) <div>([^<]+)</div></li>', page_content)

        doc['title'] = re.search(r'<h1>([^<]+)</h1>', page_content).group(1)
        doc['views'] = int(re.search(r'<li><span>Просмотров</span> (\d*)</li>', page_content).group(1) or 0)
        doc['downloads'] = int(re.search(r'<li><span>Скачиваний</span> (\d*)</li>', page_content).group(1) or 0)
        doc['download_link'] = re.search(r'<a href="([^"]+)" title="Скачать работу"', page_content).group(1)
        doc['size'] = float(size_mcs.group(1))
        doc['size_ext'] = size_mcs.group(2)

        tags1 = re.search(r'<li><span>Категория (.+?)</span></li>', page_content, re.MULTILINE).group(1)
        categories = re.findall(r'<a href="([^"]+)">([^<]+)</a>', tags1)
        categories_dict = []
        for ct in categories:
            categories_dict.append({
                'title': ct[1],
                'url': ct[0]
            })
        doc['categories'] = categories_dict

        tags2 = re.search(r'<li><span>Раздел (.+?)</span></li>', page_content, re.MULTILINE).group(1)
        chapters = re.findall(r'<a href="([^"]+)">([^<]+)</a>', tags2)
        chapters_dict = []
        for cp in chapters:
            chapters_dict.append({
                'title': cp[1],
                'url': cp[0]
            })
        doc['chapters'] = chapters_dict
        documents.update({'_id': docId}, doc)
    except:
        e = sys.exc_info()[0]
        doc['error'] = e
        documents.update({'_id': docId}, doc)
        return


counter = 1
for document in docs_arr:
    #thread = threading.Thread(target=do_parsing, args=(document, counter))
    #thread.start()
    try:
        do_parsing(document, counter)
    except:
        docs_arr.close()
        print(sys.exc_info())
        continue
    counter += 1

docs_arr.close()