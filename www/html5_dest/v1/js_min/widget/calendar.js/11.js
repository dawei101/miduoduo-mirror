define(function(require,exports){function initCalendar(currDateObj){currDateObj&&(year=currDateObj.getFullYear(),month=currDateObj.getMonth()+1),buildYearPanel(year+1,currDateObj&&currDateObj.getFullYear()),datePanel(currDateObj||date),$(".curr-y").text(year),$(".curr-m").text(month),bindEvent()}function buildYearPanel(lastYear,currYear){var tempYear=lastYear-101;firstYear=tempYear;for(var $container=$(".year-panel-container"),frag=document.createDocumentFragment(),i=1;102>=i;i++){var oDiv=document.createElement("div");if(oDiv.innerHTML=tempYear,frag.appendChild(oDiv),tempYear++,i%12==0||102==i){var $div=$("<li class='year-panel'></li>");$div.append(frag),$container.append($div),frag=document.createDocumentFragment()}}currYear=currYear?currYear:lastYear-1,panelIndex=Math.ceil((currYear-firstYear+1)/12),yearPanelTransX=-100/9*(panelIndex-1),$yearPanelContainer.css("-webkit-transform","translate3d("+yearPanelTransX+"%, 0, 0)");var $currYear=$yearPanelContainer.find("div").eq(currYear-firstYear);$currYear.addClass("y-act"),console.log(currYear,firstYear),currSelObj.y=$currYear}function datePanel(d){var currMonth=d.getMonth(),currDate=d.getDate();d.setDate(1);var n=1-d.getDay();1==n&&(n=-6),d.setDate(n);for(var frag=document.createDocumentFragment(),$div=$("<div class='day-panel'></div>"),i=0;42>i;i++){var oDiv=document.createElement("div");oDiv.innerHTML=d.getDate(),d.getMonth()!=currMonth?oDiv.className="unCurrMonthDay":(oDiv.className="currMonthDay",d.getDate()==currDate&&(oDiv.className+=" d-act")),frag.appendChild(oDiv),d.setDate(1+d.getDate())}$div.append(frag),$(".dayNum").html($div),currSelObj.d=$(".d-act")}function bindEvent(){var noSlide=!0;$(".curr-y").on("click",function(){if($(".dayNum,.dayName").css("opacity","0"),$(".month-panel-container").fadeOut(0),$yearPanelContainer.fadeIn(),noSlide){var yearPanelconterWidth=$(".year-panel-container").width();$(".year-slide").touchSlide({ul:".year-panel-container",isLoop:!1,isAuto:!1,pos:yearPanelTransX*yearPanelconterWidth*.01,index:panelIndex-1}),noSlide=!1}}),$(".curr-m").on("click",function(){$(".dayNum,.dayName").css("opacity","0"),$(".year-panel-container").fadeOut(0),$(".month-panel-container").fadeIn()}),$(".month-panel-container>li").on("click",function(){$(this).addClass("m-act"),currSelObj.m&&currSelObj.m.removeClass("m-act"),currSelObj.m=$(this);var m=$(this).text();$(".curr-m").text(m);var y=$(".curr-y").text(),d=currSelObj.d.text();$(this).parent().fadeOut(0,function(){datePanel(new Date(y+"/"+m+"/"+d)),$(".dayNum,.dayName").fadeIn()})}),$(".year-panel-container div").on("click",function(){$(this).addClass("y-act"),currSelObj.y&&currSelObj.y.removeClass("y-act"),currSelObj.y=$(this);var y=$(this).text();$(".curr-y").text(y);var m=$(".curr-m").text(),d=currSelObj.d.text();$(this).parent().parent().fadeOut(0,function(){datePanel(new Date(y+"/"+m+"/"+d)),$(".dayNum,.dayName").fadeIn()})}),$(".dayNum").on("click",".currMonthDay",function(){currSelObj.d&&currSelObj.d.removeClass("d-act"),$(this).addClass("d-act"),currSelObj.d=$(this);var y=$(".curr-y").text(),m=$(".curr-m").text(),d=currSelObj.d.text();console.log(y+"-"+m+"-"+d),$(".js-birthday").val(y+"-"+m+"-"+d),$(".calendar-widget, .shade-widget").hide(300)})}require("zepto-ext"),require("widget/touchSlide");var firstYear,panelIndex,yearPanelTransX,$yearPanelContainer=$(".year-panel-container"),currSelObj={y:null,m:null,d:null},date=new Date,year=date.getFullYear(),month=date.getMonth()+1;date.getDate();exports.initCalendar=initCalendar});