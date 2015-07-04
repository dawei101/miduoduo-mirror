# -*- coding: utf-8 -*-
import scrapy
import re

from spider.items import Task

class XlbSpider(scrapy.Spider):

    name = "xiaolianbang"
    allowed_domains = ["m.xiaolianbang.com"]

    def start_requests(self):
        return [scrapy.http.Request("http://m.xiaolianbang.com/cities",
                callback=self.parse_cities
                )]

    def parse_cities(self, response):

        content = response.body
        res = re.findall('data-city="([^"]+)"', content)
        for city in res:
            yield self.build_list_request(city, 1)

    def build_list_request(self, city, page=1):
            return scrapy.http.Request(
                    "http://m.xiaolianbang.com/?page=%s" % page,
                    cookies = {'cur_city': city},
                    meta={
                        'dont_merge_cookies': True,
                        'city': city,
                        'page': page
                        },
                    callback=self.parse_list)

    def parse_list(self, response):
        _ids = list(response.selector.xpath(
                '//*[@id="content"]/li/@data-id').extract())
        if len(_ids)>0:
            meta = response.meta
            yield self.build_list_request(meta['city'], meta['page']+1)
        for _id in _ids:
            yield self.build_detail_request(_id, meta['city'])

    def build_detail_request(self, _id, city):
        return scrapy.http.Request(
                    "http://m.xiaolianbang.com/pt/%s/detail" % _id,
                    meta = {'city': city},
                    callback=self.parse_detail)

    def parse_detail(self, response):
        task = Task()
        task['title'] = response.xpath(
                '//*[@id="info"]/div[contains(@class, "title_box")]/p/text()').extract()[0]
        labels = response.xpath(
                '//*[@id="info"]//td[contains(@class, "list_item")]').extract()
        infos = response.xpath(
                '//*[@id="info"]//td[contains(@class,"list_con")]').extract()

        for i, label in enumerate(labels):
            info = infos[i]
            if u'发布机构' in label:
                task['company_name'] = info
            elif u'薪资待遇' in label:
                task['salary'], task['salary_unit'] = re.search(
                        r'(\d+).*?/([^\<]?)', info).group(1, 2)
            elif u'结算方式' in label:
                task['clearance_period'] = info
            elif u'招聘人数' in label:
                r = re.search('(\d+)', info)
                task['need_quantity'] = r and int(r.group(1)) or 0
            elif u'性别要求' in label:
                task['gender'] = info
            elif u'工作地点' in label:
                task['address'] = info
            elif u'工作日期' in label:
                r = re.search(r'(\d+\.\d+)~(\d+\.\d+)', info)
                if r:
                    task['from_date'] = r.group(1)
                    task['to_date'] = r.group(2)
        task['content'] = response.xpath(
                '//*[@id="info"]/ul[contains(@class,"job_info")]/li[contains(@class,"info_con")]').extract()[0]
        yield task

    def parse_nearby_list(self, response):
        _ids = list(response.selector.xpath(
                '//*[@id="content"]/li/@data-id').extract())

