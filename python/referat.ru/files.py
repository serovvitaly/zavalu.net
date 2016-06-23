import urllib.request
import urllib.error
import re
import os
import hashlib
from pymongo import MongoClient

"""основной хост для парсинга"""
HOST = 'https://referat.ru'

FILES_DIR = 'D:\\server\\alumico.ru\\www\\public\\files\\refs1\\'

client = MongoClient('mongodb://localhost/alumico')
db = client.referat_ru
catalog = db.catalog
documents = db.documents

docs_arr = documents.find({
    'download_link': {'$exists': True},
    'file_name': {'$exists': False},
    'error': {'$exists': False},
    'size':{'$gt': 30}
}, no_cursor_timeout=True)

counter = 0
for doc in docs_arr:
    counter += 1
    docId = doc['_id']
    doc.pop("_id", None)
    download_link = HOST + doc['download_link']
    print(str(counter) + '. ' + download_link)
    try:
        with urllib.request.urlopen(download_link) as request:
            request_filename_re = re.search('filename="([^"]*)"', str(request.info()))
            if request_filename_re is not None:
                request_filename = request_filename_re.group(1)
                filename, file_extension = os.path.splitext(request_filename)
            else:
                file_extension = re.search('application/(.*)', str(request.info())).group(1)
            md5 = hashlib.md5()
            md5.update(download_link.encode())
            local_file_name = md5.hexdigest() + file_extension
            with open(FILES_DIR + local_file_name, 'w+b') as local_file:
                local_file.write(request.read())
                file_size = os.path.getsize(FILES_DIR + local_file_name)
                doc['file_real_size'] = file_size
                doc['file_name'] = local_file_name
                doc['file_extension'] = file_extension
                documents.update({'_id': docId}, doc)
    except urllib.error.HTTPError as error:
        doc['download_error'] = error
        documents.update({'_id': docId}, doc)
        continue
    except:
        doc['download_error'] = 'ERROR'
        documents.update({'_id': docId}, doc)
        continue

docs_arr.close()
