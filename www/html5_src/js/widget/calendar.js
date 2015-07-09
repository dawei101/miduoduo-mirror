define(function(require, exports) {
    require("zepto-ext");
    require("widget/touchSlide");
    var date = new Date();
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    initCalendar();
    function initCalendar() {
        buildYearPanel(year + 1);
        datePanel(date);
        $(".curr-y").text(year);
        $(".curr-m").text(month);
        $(".part2").touchSlide({ul : ".year-panel-container", isLoop : false, isAuto : false, pos : -0.89 * ($(".year-panel-container").width()), index : 8});
    }

    function buildYearPanel(year) {
        var startYear = year - 101;
        var $container = $(".year-panel-container");
        var frag = document.createDocumentFragment();
        for (var i = 1; i <= 102; i++) {
            var oDiv = document.createElement('div');
            oDiv.innerHTML = startYear
            frag.appendChild(oDiv);
            startYear++;
            if (i%12 == 0 || i == 102) {
                var $div = $("<li class='year-panel'></li>");
                $div.append(frag);
                $container.append($div);
                frag = document.createDocumentFragment();
            }
        }
    }

    function datePanel(d) {
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
            frag.appendChild(oDiv);
            d.setDate(1 + d.getDate());
        }
        $div.append(frag);
        $(".dayNum").html($div);
    }

    //事件区
    var currSelObj = {y : null, m : null, d : null};
    var $yearPanel = $(".year-panel-container");
    $(".curr-y").on("click", function() {
        $(".dayNum,.dayName").css("opacity", "0");
        $(".month-panel-container").css({"opacity" : "0", "-webkit-transform" :  "translate3d(0, 100%, 0)"});

        var transVal = $yearPanel.css("-webkit-transform");
        var h = transVal.substring(transVal.indexOf("(") + 1, transVal.indexOf(","));
        $yearPanel.css("-webkit-transform", "translate3d(" + h + ", 0, 0)").animate({opacity : 1}, 300);
    });
    $(".curr-m").on("click", function() {
        $(".dayNum,.dayName").css("opacity", "0");
        $(".year-panel-container").css({"opacity" : "0"});
        $(".month-panel-container").css("-webkit-transform", "translate3d(0, 0, 0)").animate({opacity : 1}, 300);
    });
    $(".month-panel-container>li").on("click", function() {
        $(this).addClass("m-act")
        if (currSelObj.m) {
            currSelObj.m.removeClass("m-act");
        }
        currSelObj.m = $(this);

        var m = $(this).text();
        $(".curr-m").text(m);
        var y = $(".curr-y").text();
        datePanel(new Date(y+"/"+m));
        $(".dayNum,.dayName").css("opacity", "1");

        $(this).parent().animate({opacity : 0}, 300, function() {
            this.css("-webkit-transform", "translate3d(0, 100%, 0)")
        })
    })

    $(".year-panel-container div").on("click", function() {
        $(this).addClass("y-act")
    })
});