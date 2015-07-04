# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class Company(scrapy.Item):
    name = scrapy.Field()


class TaskAddress(scrapy.Item):
    pass


class Task(scrapy.Item):

    title = scrapy.Field()
    category_name = scrapy.Field()
    is_long_term = scrapy.Field()
    from_date = scrapy.Field()
    to_date = scrapy.Field()
    from_time = scrapy.Field()
    to_time = scrapy.Field()
    address = scrapy.Field()
    content = scrapy.Field()
    need_quantity = scrapy.Field()
    salary = scrapy.Field()
    salary_unit = scrapy.Field()
    clearance_period = scrapy.Field()
    company_name = scrapy.Field()
    contact = scrapy.Field()
    phonenum = scrapy.Field()
    email = scrapy.Field()
    release_time = scrapy.Field()

    gender = scrapy.Field()

