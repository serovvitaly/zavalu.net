import urllib.request
import re
from pymongo import MongoClient

client = MongoClient('mongodb://localhost/alumico')
db = client.referat_ru
catalog = db.catalog

urls_arr = [
    'https://referat.ru/',
    'https://referat.ru/category/by/type/referaty',
    'https://referat.ru/category/by/type/diplom-i-svyazannoe-s-nim',
    'https://referat.ru/category/by/type/kursovaya',
    'https://referat.ru/category/by/type/doklad',
    'https://referat.ru/category/by/type/kontrolnaya',
    'https://referat.ru/category/by/type/shpargalki',
    'https://referat.ru/category/by/type/dissertaciya',
    'https://referat.ru/category/by/type/laboratornaya',
    'https://referat.ru/category/by/type/prakticheskie-zanyatiya-i-otchety',
    'https://referat.ru/category/by/type/monografiya-statya',
]

for page_url in urls_arr:
    with urllib.request.urlopen(page_url) as f:
        page_content = f.read().decode("utf-8", "ignore")
        result = re.findall(r"<li class=\"(category_dc[\d]+)\"><a href=\"([^\"]+)\">([^<]+)</a></li>", page_content, re.MULTILINE)
        for category_mix in result:
            catalog.insert({
                'base_url': page_url,
                'code': category_mix[0],
                'href': category_mix[1],
                'title': category_mix[2],
            })
