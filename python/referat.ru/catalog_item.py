import datetime
import time
import urllib.request
import re
import threading
from pymongo import MongoClient

"""основной хост для парсинга"""
HOST = 'https://referat.ru'

"""максимально количество потоков"""
MAX_THREADS = 5

START_TIME = time.time()

client = MongoClient('mongodb://localhost/alumico')
db = client.referat_ru
catalog = db.catalog
documents = db.documents

catalog_items = catalog.find({'pages': {'$exists': False}}).limit(100)


def get_page_content_by_url(url):
    url = HOST + url
    with urllib.request.urlopen(url) as f:
        content = f.read().decode("utf-8", "ignore")
        return re.sub('[\s]{10,}', '', content)


def get_last_page_by_content(content):
    pages_list = re.findall(r'<li><a href="[^"]+">([\d]+)</a></li>', content)
    if not pages_list:
        return 1
    return int(pages_list[-1])


def get_docs_by_content(content):
    return re.findall(r"<div class=\"workName\"><a href=\"([^\"]+)\">[^<]*</a></div>", content)


def do_parsing(catalog_id, page_url, counter):
    """
    Создает один поток для парсинга,
    и выполняет все операции для парсинга одного раздела
    """
    print(str(counter) + '. Starting... ' + page_url)
    docs_counter = 0
    page_content = get_page_content_by_url(page_url)
    last_page = get_last_page_by_content(page_content)
    docs = get_docs_by_content(page_content)
    for doc_url in docs:
        docs_counter += 1
        documents.update({'url': doc_url}, {
            'catalog_id': catalog_id,
            'catalog_url': page_url,
            'url': doc_url,
        }, upsert=True)
    next_page = 2
    while next_page <= last_page:
        next_page_url = page_url + '/page/' + str(next_page)
        page_content = get_page_content_by_url(next_page_url)
        next_last_page = get_last_page_by_content(page_content)
        docs = get_docs_by_content(page_content)
        for doc_url in docs:
            docs_counter += 1
            documents.update({'url': doc_url}, {
                'catalog_id': catalog_id,
                'catalog_url': page_url,
                'url': doc_url,
            }, upsert=True)
        next_page += 1
        if next_last_page > last_page:
            last_page = next_last_page
    catalog.update_one({'_id': catalog_id},
                       {'$set': {'docs': docs_counter, 'pages': last_page, 'updated_at': datetime.datetime.now()}})
    print(str(counter) + '. Done... ' + page_url + ', docs = ' + str(docs_counter) + ', pages = ' + str(last_page) + ', time = ' + str(time.time() - START_TIME))

counter = 1
for catalog_item in catalog_items:
    thread = threading.Thread(target=do_parsing, args=(catalog_item['_id'], catalog_item['href'], counter))
    thread.start()
    counter += 1
    # do_parsing(catalog_item['_id'], catalog_item['href'])


