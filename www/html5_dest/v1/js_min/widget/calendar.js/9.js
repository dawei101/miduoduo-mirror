define(function(require,exports){function initCalendar(){buildYearPanel(year+1,1987),datePanel(date),$(".curr-y").text(year),$(".curr-m").text(month),$(".part2").touchSlide({ul:".year-panel-container",isLoop:!1,isAuto:!1,pos:-.89*$(".year-panel-container").width(),index:8})}function buildYearPanel(lastYear,currYear){var tempYear=lastYear-101;firstYear=tempYear;for(var $container=$(".year-panel-container"),frag=document.createDocumentFragment(),i=1;102>=i;i++){var oDiv=document.createElement("div");if(oDiv.innerHTML=tempYear,frag.appendChild(oDiv),tempYear++,i%12==0||102==i){var $div=$("<li class='year-panel'></li>");$div.append(frag),$container.append($div),frag=document.createDocumentFragment()}}currYear=currYear?currYear:lastYear-1;var panelIndex=Math.ceil((currYear-firstYear)/12),transX=-100/9*(panelIndex-1)+"%";$yearPanel.css("-webkit-transform","translate3d("+transX+", 100%, 0)");var $currYear=$yearPanel.find("div").eq(currYear-firstYear);$currYear.addClass("y-act"),console.log(currYear,firstYear),currSelObj.y=$currYear}function datePanel(d){d.setDate(1);var n=1-d.getDay();1==n&&(n=-6),d.setDate(n);for(var frag=document.createDocumentFragment(),$div=$("<div class='day-panel'></div>"),i=0;42>i;i++){var oDiv=document.createElement("div");oDiv.innerHTML=d.getDate(),frag.appendChild(oDiv),d.setDate(1+d.getDate())}$div.append(frag),$(".dayNum").html($div)}require("zepto-ext"),require("widget/touchSlide");var firstYear,$yearPanel=$(".year-panel-container"),currSelObj={y:null,m:null,d:null},date=new Date,year=date.getFullYear(),month=date.getMonth()+1;date.getDate();initCalendar(),$(".curr-y").on("click",function(){$(".dayNum,.dayName").css("opacity","0"),$(".month-panel-container").css({opacity:"0","-webkit-transform":"translate3d(0, 100%, 0)"});var transVal=$yearPanel.css("-webkit-transform"),h=transVal.substring(transVal.indexOf("(")+1,transVal.indexOf(","));$yearPanel.css("-webkit-transform","translate3d("+h+", 0, 0)").animate({opacity:1},300)}),$(".curr-m").on("click",function(){$(".dayNum,.dayName").css("opacity","0"),$(".year-panel-container").css({opacity:"0"}),$(".month-panel-container").css("-webkit-transform","translate3d(0, 0, 0)").animate({opacity:1},300)}),$(".month-panel-container>li").on("click",function(){$(this).addClass("m-act"),currSelObj.m&&currSelObj.m.removeClass("m-act"),currSelObj.m=$(this);var m=$(this).text();$(".curr-m").text(m);var y=$(".curr-y").text();datePanel(new Date(y+"/"+m)),$(".dayNum,.dayName").css("opacity","1"),$(this).parent().animate({opacity:0},300,function(){this.css("-webkit-transform","translate3d(0, 100%, 0)")})}),$(".year-panel-container div").on("click",function(){$(this).addClass("y-act"),currSelObj.y&&currSelObj.y.removeClass("y-act"),currSelObj.y=$(this);var y=$(this).text();$(".curr-y").text(y);var m=$(".curr-m").text();datePanel(new Date(y+"/"+m)),$(".dayNum,.dayName").css("opacity","1"),$(this).parent().parent().animate({opacity:0},300,function(){var transVal=$yearPanel.css("-webkit-transform"),h=transVal.substring(transVal.indexOf("(")+1,transVal.indexOf(","));$yearPanel.css("-webkit-transform","translate3d("+h+", 100%, 0)")})})});