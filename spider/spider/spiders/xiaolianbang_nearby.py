# -*- coding: utf-8 -*-
import scrapy
import re
import urllib2
from scrapy.utils.project import get_project_settings

from spider.items import Task

class XlbNearbySpider(scrapy.Spider):

    name = "xiaolianbang_nearby"
    allowed_domains = ["m.xiaolianbang.com"]

    city_locations = {}


    def get_city_location(city):
        baseurl = "http://api.map.baidu.com/geocoder?address=%s&output=json&key=%s"
        url = baseurl % (city, self.settings.get('BAIDU_MAP_KEY'))
        try:
            fp = urllib2.urlopen(url)
            c = fp.read()
            r = simplejson.loads(c)
            return r['status']=='OK' and r['result'] and r['result']['location']
        except Exception, e:
            self.logger.info(
                    "Failed to get city: %s's location from baidu map",
                    city)

    def start_requests(self):
        return [scrapy.http.Request("http://m.xiaolianbang.com/cities",
                callback=self.parse_cities
                )]

    def parse_cities(self, response):

        content = response.body
        res = re.findall('data-city="([^"]+)"', content)
        for city in res:
            location  = self.get_city_location(city)
            if location:
                self.city_locations[city] = location
            else:
                self.logger.error(
                        "No location for :%s , we cloud not get nearby list of this city",
                        city)
        for city in self.city_locations.keys():
            yield self.build_list_request(city, 1)

    def build_list_request(self, city, page=1, location=None):
        if not location:
            location = self.city_locations[city]

        return scrapy.http.Request(
                "http://m.xiaolianbang.com/pt/nearby?page=%s&lng=%s&lat=%s" % (
                    page, location['lng'], location['lat'])
                cookies = location,
                meta={
                    'city': city,
                    'page': page,
                    'location': location,
                    },
                callback=self.parse_list)

    def parse_list(self, response):
        self.logger.debug("request cookie is %s",
                response.request.cookies)
        _ids = list(response.selector.xpath(
                '//*[@id="content"]/li/@data-id').extract())

        if len(_ids)>0:
            task_list =  NearbyTaskList()
            task_list['ids'] = _ids
            yield task_list
            location = response.meta['location']
            yield self.build_detail_request(_id, meta['city'])

