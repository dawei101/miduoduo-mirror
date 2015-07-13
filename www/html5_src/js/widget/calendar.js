define(function(require, exports) {
    require("zepto-ext");
    require("widget/touchSlide");
    var $yearPanelContainer = $(".year-panel-container");
    var currSelObj = {y : null, m : null, d : null};
    var firstYear;
    var panelIndex;
    var yearPanelTransX;

    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();

    function initCalendar(currDateObj) {
        if (currDateObj) {
            year = currDateObj.getFullYear();
            month = currDateObj.getMonth() + 1;
        }
        buildYearPanel(year + 1, currDateObj && currDateObj.getFullYear());
        datePanel(currDateObj || date);
        buildMonthPanel(currDateObj || date);
        $(".curr-y").text(year);
        $(".curr-m").text(month);

        bindEvent();
    }

    function buildMonthPanel(date) {
        var m = date.getMonth();
        var $currMonth = $(".month-panel-container").children().eq(m - 1);
        $currMonth.addClass("m-act");
        currSelObj.m = $currMonth;
    }

    function buildYearPanel(lastYear, currYear) {
        var tempYear = lastYear - 101;
        firstYear = tempYear;
        var $container = $(".year-panel-container");
        var frag = document.createDocumentFragment();
        for (var i = 1; i <= 102; i++) {
            var oDiv = document.createElement('div');
            oDiv.innerHTML = tempYear;
            frag.appendChild(oDiv);
            tempYear++;
            if (i%12 == 0 || i == 102) {
                var $div = $("<li class='year-panel'></li>");
                $div.append(frag);
                $container.append($div);
                frag = document.createDocumentFragment();
            }
        }

        //年面板初始位置
        currYear = currYear ? currYear : (lastYear - 1);
        panelIndex = Math.ceil((currYear - firstYear + 1)/12);
        yearPanelTransX = -100/9*(panelIndex - 1);
        $yearPanelContainer.css("-webkit-transform", "translate3d(" + yearPanelTransX + "%, 0, 0)");
        var $currYear = $yearPanelContainer.find("div").eq(currYear - firstYear);
        $currYear.addClass("y-act");
        console.log(currYear, firstYear);
        currSelObj.y = $currYear;
    }

    function datePanel(d) {
        var currMonth = d.getMonth();
        var currDate = d.getDate();
        d.setDate(1);
        var n = 1 - d.getDay();
        if (n == 1) {
            n = -6;
        }
        d.setDate(n);
        var frag = document.createDocumentFragment();
        var $div = $("<div class='day-panel'></div>")
        for (var i = 0; i < 42; i++) {
            var oDiv = document.createElement('div');
            oDiv.innerHTML = d.getDate();
            if (d.getMonth() != currMonth) {
                oDiv.className = "unCurrMonthDay";
            } else {
                oDiv.className = "currMonthDay";
                if (d.getDate() == currDate) {
                    oDiv.className += " d-act";
                }
            }
            frag.appendChild(oDiv);
            d.setDate(1 + d.getDate());
        }
        $div.append(frag);
        $(".dayNum").html($div);

        currSelObj.d = $(".d-act");
    }

    //事件区
    function bindEvent() {
        var noSlide = true;
        $(".curr-y").on("click", function() {
            $yearPanelContainer.fadeIn(100);
            $(".dayNum,.dayName").css("opacity", "0");
            $(".month-panel-container").fadeOut(0);


            if (noSlide) {
                var yearPanelconterWidth = $(".year-panel-container").width();
                $(".year-slide").touchSlide({ul : ".year-panel-container", isLoop : false, isAuto : false, pos : yearPanelTransX*yearPanelconterWidth*0.01, index : panelIndex-1});
                noSlide = false;
            }
        });
        $(".curr-m").on("click", function() {
            $(".dayNum,.dayName").css("opacity", "0");
            $(".year-panel-container").fadeOut(0);
            $(".month-panel-container").fadeIn();
        });
        $(".month-panel-container>li").on("click", function() {
            $(this).addClass("m-act");
            if (currSelObj.m) {
                currSelObj.m.removeClass("m-act");
            }
            currSelObj.m = $(this);

            var m = $(this).text();
            $(".curr-m").text(m);
            var y = $(".curr-y").text();
            var d = currSelObj.d.text();

            $(this).parent().fadeOut(0,function() {
                datePanel(new Date(y+"/"+m + "/" + d));
                $(".dayNum,.dayName").fadeIn();
            });
        })

        $(".year-panel-container div").on("click", function() {
            $(this).addClass("y-act");

            if (currSelObj.y) {
                currSelObj.y.removeClass("y-act");
            }
            currSelObj.y = $(this);

            var y = $(this).text();
            $(".curr-y").text(y);
            var m = $(".curr-m").text();
            var d = currSelObj.d.text();

            $(this).parent().parent().fadeOut(0,function() {
                datePanel(new Date(y+"/"+m + "/" + d));
                $(".dayNum,.dayName").fadeIn();
            });
        })

        $(".dayNum").on("click", ".currMonthDay", function() {
            if (currSelObj.d) {
                currSelObj.d.removeClass("d-act");
            }
            $(this).addClass("d-act");
            currSelObj.d = $(this);
            var y = $(".curr-y").text();
            var m = $(".curr-m").text();
            var d =  currSelObj.d.text();
            console.log(y + "-" + m + "-" +d);
            $(".js-birthday").val(y + "-" + m + "-" + d);
            $(".calendar-widget, .shade-widget").hide(300);
        })
    }


    exports.initCalendar = initCalendar;
});