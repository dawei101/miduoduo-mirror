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
        $(".part2").touchSlide({ui : "year-panel-container", isLoop : false, isAuto : false, pos : -0.89 * ($(".year-panel-container").width()), index : 8});
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
        $(".dayNum").append($div);
    }

    //事件区
    $(".curr-y").on("click", function() {
        $(".year-panel-container").css("-webkit-transform", "translate3d(-88.8%, 0, 0)").animate({opacity : 1}, 300);
    });
});