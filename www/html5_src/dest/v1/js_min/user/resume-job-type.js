define(function(require,exports){require("zepto");var api=(require("../widget/url-handle"),require("../widget/api")),tpl=require("../widget/tpl-engine");$.get(api.gen("service-type"),function(data){$("body").append(tpl.parse("job-type-list-tpl",{list:data.items,as:""}))},"json"),$("body").on("click",".type-content .type-item",function(){var $this=$(this),typeCode=$this.data("code");$this.hasClass("type-act")?($this.removeClass("type-act"),$["delete"](api.gen("user-service-type/"+typeCode),function(data){console.log(data)})):($this.addClass("type-act"),$.post(api.gen("user-service-type"),{service_type_id:typeCode},function(data){console.log(data)}))}),$("body").on("click",".type-submit",function(){var typesStr="",$selType=$(".type-act");$selType.each(function(){typesStr+=" "+$(this).text()});var $st=$(".js-sel-service-type");$selType.length>0?$st.find("input").hide():$st.find("input").show(),$st.find("span").text(typesStr).show(),$(".sel-job-type").hide(),$(".main2").show()})});