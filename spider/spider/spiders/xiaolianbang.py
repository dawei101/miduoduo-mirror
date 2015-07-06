# -*- coding: utf-8 -*-
import scrapy
import re
import simplejson
import datetime

from spider.items import Task
from spider import utils
from scrapy.http.cookies import CookieJar


class XlbSpider(scrapy.Spider):

    name = "xiaolianbang"

    origin = 'xiaolianbang'

    exists_ids = set()

    this_year = '%s' % datetime.date.today().year

    def start_requests(self):
        yield scrapy.http.Request("http://m.xiaolianbang.com/",
                callback=self.login)

    def login(self , response):

        params = {
                'user_acc': '18661775819',
                'user_pwd': '123123'
                }
        yield scrapy.http.FormRequest(
                "http://m.xiaolianbang.com/user/login",
                self.parse_login,
                formdata=params)

    def parse_login(self, response):
        if not re.search(r'error_code\":0', response.body):
            self.logger.error("Could not login xiaolianbang , quiting .....")
            import sys
            sys.exit("Quit scraping data....")
        yield scrapy.http.Request("http://m.xiaolianbang.com/cities",
                callback=self.parse_cities)


    def parse_cities(self, response):

        content = response.body
        res = re.findall('data-city="([^"]+)"', content)
        for city in res:
            yield self.build_list_request(city.decode('utf-8'), 1)

    def build_list_request(self, city, page=1):
        cookies = {}
        cookies['cur_city'] = city
        return scrapy.http.Request(
                "http://m.xiaolianbang.com/?page=%s" % page,
                cookies = cookies,
                meta={
                    'city': city,
                    'page': page,
                    },
                dont_filter=True,
                callback=self.parse_list)

    def parse_list(self, response):
        self.logger.debug("request cookie is %s",
                response.request.cookies)
        self.logger.debug("request cookie is %s",
                response.request.cookies)
        _ids = list(response.selector.xpath(
                '//*[@id="content"]/li/@data-id').extract())

        lis = response.selector.xpath(
                '//*[@id="content"]/li')
        if len(lis)>0:
            meta = response.meta
            yield self.build_list_request(meta['city'], meta['page']+1)
        for li in lis:
            _id = li.xpath('@data-id').extract_first();
            release_date = li.xpath(
                    '//div[contains(@class, "time")]/text()').extract_first()
            if _id and re.match(r'\d{2}-\d{2}', release_date):
                release_date = self.this_year + '-' + str(release_date)

                if (int(_id) not in self.exists_ids):
                    yield self.build_detail_request(_id, meta['city'], release_date)

    def build_detail_request(self, _id, city, release_date=None):
        if not release_date:
            release_date = str(datetime.date.today())
        return scrapy.http.Request(
                    "http://m.xiaolianbang.com/pt/%s/detail" % _id,
                    meta = {
                        'city': city,
                        'id': _id,
                        'release_date': release_date,
                        },
                    callback=self.parse_detail)

    def parse_detail(self, response):
        try:
            task = Task()

            task['lat'] = None
            task['lng'] = None
            task['email'] = None
            task['phonenum'] = None
            task['address'] = None
            task['contact'] = None
            task['need_quantity'] = 0
            task['from_date'] = '1999-09-09'
            task['to_date'] = '1999-09-09'
            
            task['release_date'] = response.meta['release_date']

            self.logger.debug(
                    "The release date is : %s", task['release_date'])
            task['id'] = response.meta['id']
            task['city'] = response.meta['city']
            task['origin'] = self.origin
            task['title'] = response.xpath(
                    '//*[@id="info"]/div[contains(@class, "title_box")]/p/text()')\
                            .extract_first()

            task['category_name'] = response.xpath(
                    '//*[@id="info"]/div[contains(@class, "title_box")]/div/text()')\
                            .extract_first()

            trs = response.xpath(
                    '//*[@id="info"]//div[contains(@class, "info_list")]//tr')

            for tr in trs:
                label = tr.xpath(
                        'td[contains(@class,"list_item")]/text()')\
                                .extract_first()
                info = tr.xpath(
                        'td[contains(@class,"list_con")]/text()')\
                                .extract_first()
                if label and info:
                    label = label.encode('utf-8')
                    info = info.encode('utf-8').decode('utf-8')
                else:
                    continue
                self.logger.debug(
                        "parse field: %s value: %s",
                        label.decode('utf-8'), info)
                if '发布机构' in label:
                    task['company_name'] = info
                elif '薪资待遇' in label:
                    task['salary'], task['salary_unit'] = 0, None
                    if info:
                        r = re.search(ur'(\d+).*?/([^\<]?)', info)
                        if r:
                            task['salary'], task['salary_unit'] = r.group(1, 2)
                elif '结算方式' in label:
                    task['clearance_period'] = info
                elif '招聘人数' in label:
                    if info:
                        r = re.search(ur'(\d+)', info)
                        task['need_quantity'] = r and int(r.group(1)) or 0
                elif '性别要求' in label:
                    task['gender'] = info
                elif '工作地点' in label:
                    task['address'] = info
                    if info and ("不限" in info.encode('utf-8')):
                        task['address'] = None
                elif '工作日期' in label:
                    r = re.search(ur'(\d+\.\d+)~(\d+\.\d+)', info)
                    if r:
                        task['is_long_term'] = False;
                        task['from_date'] = self.this_year + '-' + '-'.join(r.group(1).split('.'))
                        task['to_date'] = self.this_year + '-' + '-'.join(r.group(2).split('.'))
            cnodes = response.xpath(
                    '//*[@id="info"]/ul[contains(@class,"job_info")]/li[contains(@class,"info_con")]/node()').extract()
            task['content'] = "\n".join(cnodes)
            yield self.build_contact_request(task)

        except Exception, e:
            self.logger.error("parse detail failed with error: %s" % e)


    def build_contact_request(self, task):
        self.logger.debug("Build apply request for task: %s, %s", task['id'], task['title'])
        return scrapy.http.Request(
                'http://m.xiaolianbang.com/pt/%s/apply' % task['id'],
                meta = {
                     'task': task,
                     },
                callback=self.parse_contact)

    def parse_contact(self, response):
        task = response.meta['task']
        tits = response.xpath(
                '//*[@id="con_box"]/li[contains(@class, "sub_tit")]/text()').extract()
        cons = response.xpath(
                '//*[@id="con_box"]/li[contains(@class, "sub_con")]').extract()

        for i, tit in enumerate(tits):
            if tits[i] in u'电话报名':
                cr = re.search(ur'>联系人：(.*?)<', cons[i])
                if cr:
                    task['contact'] = cr.group(1)
                pr = re.search(ur'>电话号码：(\d+)<', cons[i])
                if pr:
                    task['phonenum'] = pr.group(1)
            elif tits[i] in u'其他方式':
                r = re.search(ur'[\d\w\_\-\.]+\@([\w\_\-\_]+\.)+([\w]+)', cons[i])
                if r:
                    task['email'] = r.group(0)
        yield task

        if task['address']:
            self.logger.debug("start scrape location for address: %s", task['address'])
            yield scrapy.http.Request(
                    utils.build_pio_url(task['address'], task['city']),
                    meta = {
                         'task': task,
                         },
                    callback=self.parse_poi)



    def parse_poi(self, response):

        r = simplejson.loads(response.body)
        task = response.meta['task']
        location = r['status']=='OK' and r['result'] and r['result']['location']
        self.logger.debug("got poi: %s" % location)
        if (location):
            task['lat'] = location['lat']
            task['lng'] = location['lng']
        yield task


