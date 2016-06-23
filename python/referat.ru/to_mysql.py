import zipfile

import pymysql
from pymongo import MongoClient
import docx2txt

FILES_DIR = 'D:\\server\\alumico.ru\\www\\public\\files\\refs1\\'

client = MongoClient('mongodb://localhost/alumico')
db = client.referat_ru
catalog = db.catalog
documents = db.documents

docs_arr = documents.find({
    'file_name': {'$exists': True},
    'send_to_server': {'$exists': False},
    'file_extension': '.docx',
    'error': {'$exists': False}
}, no_cursor_timeout=True)

conn = pymysql.connect(host='176.112.205.12', user='referats', password='123456', db='referats', charset='utf8mb4')
cursor = conn.cursor()

counter = 1
for doc in docs_arr:
    try:
        file_path = FILES_DIR + doc['file_name']
        print(str(counter)+'. Sending... ' + doc['file_name'])
        text = docx2txt.process(file_path)
        sql = 'insert into documents (mongo_doc_id,title,content,file_name) values(%s, %s, %s, %s)'
        result = cursor.execute(sql, [
            str(doc['_id']),
            doc['title'],
            docx2txt.process(file_path),
            doc['file_name']
        ])
        conn.commit()
        documents.update_one({'_id': doc['_id']}, {'$set': {'send_to_server': True}})
        counter += 1
    except zipfile.BadZipFile:
        print('Error BadZipFile')
        documents.update_one({'_id': doc['_id']}, {'$set': {'error': 'zipfile.BadZipFile'}})
        counter += 1
        continue
    except FileNotFoundError:
        print('Error FileNotFoundError')
        documents.update_one({'_id': doc['_id']}, {'$set': {'error': 'FileNotFoundError'}})
        counter += 1
        continue


docs_arr.close()
