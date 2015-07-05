# -*- coding: utf-8 -*-
import scrapy
import re

from spider.items import Task
from spider import utils

class XlbSpider(scrapy.Spider):

    name = "xiaolianbang"
    allowed_domains = ["m.xiaolianbang.com"]

    origin = 'xiaolianbang'

    exists_ids = set()

    def start_requests(self):
        return [scrapy.http.Request("http://m.xiaolianbang.com/cities",
                callback=self.parse_cities
                )]

    def parse_cities(self, response):

        content = response.body
        res = re.findall('data-city="([^"]+)"', content)
        for city in res:
            yield self.build_list_request(city.decode('utf-8'), 1)

    def build_list_request(self, city, page=1):
            return scrapy.http.Request(
                    "http://m.xiaolianbang.com/?page=%s" % page,
                    cookies = {'cur_city': city},
                    meta={
                        'city': city,
                        'page': page
                        },
                    dont_filter=True,
                    callback=self.parse_list)

    def parse_list(self, response):
        self.logger.debug("request cookie is %s",
                response.request.cookies['cur_city'])
        self.logger.debug("request cookie is %s",
                response.request.cookies['cur_city'])
        _ids = list(response.selector.xpath(
                '//*[@id="content"]/li/@data-id').extract())
        if len(_ids)>0:
            meta = response.meta
            yield self.build_list_request(meta['city'], meta['page']+1)
        for _id in _ids:
            if (int(_id) not in self.exists_ids):
                yield self.build_detail_request(_id, meta['city'])

    def build_detail_request(self, _id, city):
        return scrapy.http.Request(
                    "http://m.xiaolianbang.com/pt/%s/detail" % _id,
                    meta = {
                        'city': city,
                        'id': _id,
                        },
                    callback=self.parse_detail)

    def parse_detail(self, response):
        try:
            task = Task()
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
                                .extract_first().encode('utf-8').decode('utf-8')
                self.logger.debug("parse field: %s value: %s", label, info)
                if u'发布机构' in label:
                    task['company_name'] = info
                elif u'薪资待遇' in label:
                    if u'面议' in info:
                        task['salary'], task['salary_unit'] = 0, None
                    else:
                        task['salary'], task['salary_unit'] = re.search(
                                ur'(\d+).*?/([^\<]?)', info).group(1, 2)
                elif u'结算方式' in label:
                    task['clearance_period'] = info
                elif u'招聘人数' in label:
                    r = re.search(ur'(\d+)', info)
                    task['need_quantity'] = r and int(r.group(1)) or 0
                elif u'性别要求' in label:
                    task['gender'] = info
                elif u'工作地点' in label:
                    task['address'] = info
                    if u"不限" in info:
                        task['address'] = None
                elif u'工作日期' in label:
                    r = re.search(ur'(\d+\.\d+)~(\d+\.\d+)', info)
                    if r:
                        task['from_date'] = r.group(1)
                        task['to_date'] = r.group(2)
            cnodes = response.xpath(
                    '//*[@id="info"]/ul[contains(@class,"job_info")]/li[contains(@class,"info_con")]/node()').extract()
            task['content'] = "\n".join(cnodes)
            task['lat'] = None
            task['lng'] = None
            if task['address']:
                location = utils.get_location(task['address'], task['city'])
                if (location):
                    task['lat'] = location['lat']
                    task['lng'] = location['lng']
            yield task
        except Exception, e:
            self.logger.error("parse detail failed with error: %s" % e)

