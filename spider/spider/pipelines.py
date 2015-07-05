# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: http://doc.scrapy.org/en/latest/topics/item-pipeline.html

from spider.items import Task
from spider.items import Company
from spider.items import NearbyTaskList
from scrapy.utils.project import get_project_settings
import MySQLdb
import simplejson
import logging

logger = logging.getLogger(__file__)


class SpiderPipeline(object):

    def __init__(self):
        mysql_config = get_project_settings().get('MYSQL_CONFIG')
        self.db = MySQLdb.connect(**mysql_config)
        self.db.autocommit(False)

    def open_spider(self, spider):
        pass

    def close_spider(self, spider):
        pass

    def process_item(self, item, spider):

        if isinstance(item, Task):
            cursor = self.db.cursor()
            try:
                cursor.execute("""insert into jz_task_pool 
                (company_name, city, origin_id, origin, details)
                    values (%(company_name)s, %(city)s, %(origin_id)s, %(origin)s, %(details)s)
                    """, {
                        'company_name': item['company_name'],
                        'origin_id': item['id'],
                        'city': item['city'],
                        'origin': spider.name,
                        'details': simplejson.dumps(dict(item)),
                        })
                self.db.commit()
            except MySQLdb.IntegrityError, e:
                self.db.rollback()
                logger.log(logging.DEBUG, "task exists: %s, %s , %s , %s" % (
                    item['id'], spider.name, item['title'], item['city'].decode('utf-8')))
            except Exception, e:
                self.db.rollback()
                logger.log(logging.WARNING, "insert task failed with error: %s " % e)
            finally:
                cursor.close()

        if isinstance(item, NearbyTaskList):
            cursor = db.cursor()
            try:
                format_strings = ','.join(['%s'] * len(item['ids']))
                cursor.execute("""
                    update jz_task_pool set has_poi = true where id in (%s) and origin=%s where has_poi = false
                """ % format_strings, tuple(items['ids']))
            except:
                pass

