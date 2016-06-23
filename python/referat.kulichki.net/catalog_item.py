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
db = client.referat_kulichki_net
catalog = db.catalog
documents = db.documents

catalog_items = catalog.find({'pages': {'$exists': False}}).limit(10)


def get_page_content_by_url(url, attempt = 1):
    url = url
    try:
        with urllib.request.urlopen(url) as f:
            content = f.read().decode("windows-1251", "ignore")
            return content
    except:
        if attempt > 5:
            print('Не удалось получить страницу с пяти попыток, URL = ' + url)
            return None
        time.sleep(3)
        attempt += 1
        print('Попытка - ' + str(attempt))
        return get_page_content_by_url(url, attempt)


def get_last_page_by_content(content):
    pages_list = re.findall(r'<option value="[\d]+/index.html" selected="selected">1 of (\d+)</option>', content)
    if not pages_list:
        return 1
    return int(pages_list[1])


def get_docs_by_content(content):
    return re.findall(r'<td height="3"[^>]*>.*?\n\s([^<^>]+)\n</a>.*?<a href="(http://referat.kulichki.net/cgi-bin/essays/jump.cgi\?ID=[\d]+)">', content, re.DOTALL)


def do_parsing(catalog_id, page_url, counter):
    """
    Создает один поток для парсинга,
    и выполняет все операции для парсинга одного раздела
    """
    uniq_num = re.search('http://referat.kulichki.net/pages/(\d+)/index.html', page_url).group(1)
    print(str(counter) + '. Starting... ' + page_url)
    time.sleep(3)
    docs_counter = 0
    page_content = get_page_content_by_url(page_url)
    last_page = get_last_page_by_content(page_content)
    docs = get_docs_by_content(page_content)
    print('Page 1 from ' + str(last_page))
    for doc in docs:
        doc_url = doc[1]
        docs_counter += 1
        documents.update({'url': doc_url}, {
            'catalog_id': catalog_id,
            'catalog_url': page_url,
            'title': doc[0],
            'download_link': doc_url,
        }, upsert=True)
    next_page = 2
    while next_page <= last_page:
        time.sleep(0.5)
        next_page_url = 'http://referat.kulichki.net/pages/'+uniq_num+'/more'+str(next_page)+'.html'
        page_content = get_page_content_by_url(next_page_url)
        docs = get_docs_by_content(page_content)
        print('Page '+str(next_page)+' from ' + str(last_page))
        for doc in docs:
            doc_url = doc[1]
            docs_counter += 1
            documents.update({'url': doc_url}, {
                'catalog_id': catalog_id,
                'catalog_url': page_url,
                'title': doc[0],
                'download_link': doc_url,
            }, upsert=True)
        next_page += 1
    catalog.update_one({'_id': catalog_id},
                       {'$set': {'docs': docs_counter, 'pages': last_page, 'updated_at': datetime.datetime.now()}})
    print(str(counter) + '. Done... ' + page_url + ', docs = ' + str(docs_counter) + ', pages = ' + str(last_page) + ', time = ' + str(time.time() - START_TIME))

counter = 1
for catalog_item in catalog_items:
    #thread = threading.Thread(target=do_parsing, args=(catalog_item['_id'], catalog_item['href'], counter))
    #thread.start()
    try:
        do_parsing(catalog_item['_id'], catalog_item['href'], counter)
    except TimeoutError:
        print(str(counter) + '. counter')
    counter += 1
