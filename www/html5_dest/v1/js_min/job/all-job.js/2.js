define(function(require,exports,module){require("zepto");var tpl=require("../widget/tpl-engine"),jobs=[{title:"APP下载推广线下征集",salaryInfo:"120/天",paymentType:"日结",workTime:"仅周末",district:"朝阳区",pubTime:"06/11"},{title:"APP下载推广线下征集",salaryInfo:"底薪120元，提成每单8元",paymentType:"完工结算",workTime:"长期招聘",district:"海淀区",pubTime:"06/11"},{title:"APP下载推广线下征集",salaryInfo:"底薪120元，提成每单8元",paymentType:"完工结算",workTime:"长期招聘",district:"海淀区",pubTime:"06/11"},{title:"APP下载推广线下征集",salaryInfo:"底薪120元，提成每单8元",paymentType:"完工结算",workTime:"长期招聘",district:"海淀区",pubTime:"06/11"}];$(".content").append(tpl.parse("job-list-tpl",{jobs:jobs}))});