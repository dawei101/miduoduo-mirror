if(!window.jQuery){var jQuery=Zepto;!function($){["width","height"].forEach(function(dimension){$.fn[dimension]=function(value){var offset,body=document.body,html=document.documentElement,Dimension=dimension.replace(/./,function(m){return m[0].toUpperCase()});return void 0===value?this[0]==window?html["client"+Dimension]:this[0]==document?Math.max(body["scroll"+Dimension],body["offset"+Dimension],html["client"+Dimension],html["scroll"+Dimension],html["offset"+Dimension]):(offset=this.offset())&&offset[dimension]:this.each(function(idx){$(this).css(dimension,value)})}}),["width","height"].forEach(function(dimension){var Dimension=dimension.replace(/./,function(m){return m[0].toUpperCase()});$.fn["outer"+Dimension]=function(margin){var elem=this;if(elem){var size=elem[0]["offset"+Dimension],sides={width:["left","right"],height:["top","bottom"]};return sides[dimension].forEach(function(side){margin&&(size+=parseInt(elem.css("margin-"+side),10))}),size}return null}}),["width","height"].forEach(function(dimension){var Dimension=dimension.replace(/./,function(m){return m[0].toUpperCase()});$.fn["inner"+Dimension]=function(){var elem=this;if(elem[0]["inner"+Dimension])return elem[0]["inner"+Dimension];var size=elem[0]["offset"+Dimension],sides={width:["left","right"],height:["top","bottom"]};return sides[dimension].forEach(function(side){size-=parseInt(elem.css("border-"+side+"-width"),10)}),size}}),["Left","Top"].forEach(function(name,i){function isWindow(obj){return obj&&"object"==typeof obj&&"setInterval"in obj}function getWindow(elem){return isWindow(elem)?elem:9===elem.nodeType?elem.defaultView||elem.parentWindow:!1}var method="scroll"+name;$.fn[method]=function(val){var elem,win;return void 0===val?(elem=this[0])?(win=getWindow(elem),win?"pageXOffset"in win?win[i?"pageYOffset":"pageXOffset"]:win.document.documentElement[method]||win.document.body[method]:elem[method]):null:void this.each(function(){if(win=getWindow(this)){var xCoord=i?$(win).scrollLeft():val,yCoord=i?val:$(win).scrollTop();win.scrollTo(xCoord,yCoord)}else this[method]=val})}}),$._extend=$.extend,$.extend=function(){return arguments[0]=arguments[0]||{},$._extend.apply(this,arguments)}}(jQuery)}