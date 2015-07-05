# -*- coding: utf-8 -*-
import urllib2
import simplejson
import logging

from scrapy.utils.project import get_project_settings

logger = logging.getLogger(__file__)


settings = get_project_settings()

def build_pio_url(address, city=''):
    baseurl = "http://api.map.baidu.com/geocoder?address=%s&output=json&key=%s&city=%s"
    return baseurl % (
            address.encode('utf-8'),
            settings.get('BAIDU_MAP_KEY'), city.encode('utf-8'))


def get_location(address, city=''):
    url = build_pio_url(address)
    logger.debug(
            "get city: %s url: %s",
            city, url)
    try:
        fp = urllib2.urlopen(url)
        c = fp.read()
        r = simplejson.loads(c)
        return r['status']=='OK' and r['result'] and r['result']['location']
    except Exception, e:
        logger.info(
                "Failed to get city: %s's location from baidu map, with exception: %s",
                city, e)
