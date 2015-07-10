define(function(require,exports,module){!function($){function TouchSlide(el,opts){var self=this;self.pos=0,self.preIndex=0,self.wrap=el,self.index=0,self.ul=self.wrap.find(opts.ul),self.li=self.ul.find(opts.li),self.len=self.li.length,self.ul.css("width",100*(self.len+(opts.isLoop?2:0))+"%"),self.li.css("width",100/(self.len+(opts.isLoop?2:0))+"%"),self.liWidth=self.li.width(),self.numBox=self.wrap.find(opts.numBox),self.isLoop=opts.isLoop,self.isAuto=opts.isAuto,self.lazyLoad=opts.lazyLoad,self.imgSrc=opts.imgSrc,self.cur=opts.cur,self.speed=opts.speed,self.autoTime=opts.autoTime,self.timer=null,self.allowTouch=!0,self.init()}TouchSlide.prototype={init:function(){var self=this;self.config(),self.autoPlay(),self.bind()},config:function(){for(var self=this,m=0;m<self.len;m++)self.numBox.append("<b>"+(m+1)+"/"+self.len+"</b>");if(self.numBoxB=self.numBox.children(),self.numBoxB.eq(0).addClass(self.cur),self.lazyLoad)for(var n=0;n<self.len;n++)self.li.eq(n).append("<div class='loading-cover'></div>");self.isLoop?(self.ul.width(self.liWidth*(self.len+2)),self.lazyLoad?self.loadImg(0,function(){self.li.eq(0).clone().appendTo(self.ul),self.loadImg(self.len-1,function(){self.li.eq(self.len-1).clone().appendTo(self.ul),self.ul.children().eq(self.len+1).css({position:"relative",left:-self.liWidth*(self.len+2)})})}):(self.li.eq(0).clone().appendTo(self.ul),self.li.eq(self.len-1).clone().appendTo(self.ul),self.ul.children().eq(self.len+1).css({position:"relative",left:-self.liWidth*(self.len+2)}))):(self.lazyLoad&&self.loadImg(0),self.ul.width(self.liWidth*self.len))},move:function(){var self=this;self.allowTouch=!1,self.preIndex=self.index,0==arguments[0]?self.isLoop?self.index++:self.index<self.len-1?self.index++:clearInterval(self.timer):1==arguments[0]&&(!self.isLoop&&self.index>0?self.index--:self.isLoop&&self.index--);var pp=self.liWidth*Math.abs(self.preIndex-self.index);0==arguments[0]&&(pp=-1*pp),self.pos=self.pos+pp,self.ul.animate({"-webkit-transform":"translate3d("+self.pos+"px,0,0)"},self.speed,function(){self.allowTouch=!0,self.lazyLoad&&self.loadImg(self.index),self.index>self.len-1?(self.pos=0,self.ul.css("-webkit-transform","translate3d(0,0,0)"),self.index=0):self.index<0&&(self.pos=-self.liWidth*(self.len-1),self.ul.css("-webkit-transform","translate3d("+-self.liWidth*(self.len-1)+"px,0,0)"),self.index=self.len-1)}),self.numBoxB.removeClass(self.cur).eq(self.index).addClass(self.cur),self.isLoop&&self.index==self.len&&self.numBoxB.removeClass(self.cur).eq(0).addClass(self.cur)},loadImg:function(index,callback){var self=this;if(self.lazyLoad){var o=self.li.eq(index).find("img");if(o.attr(self.imgSrc)){var img=new Image;img.src=o.attr(self.imgSrc),img.onload=function(){o.attr("src",img.src),o.removeAttr(self.imgSrc),self.li.eq(index).find(".loading-cover").remove(),callback&&"function"==typeof callback&&callback()}}}},autoPlay:function(){var self=this;clearInterval(self.timer),self.isAuto&&(self.timer=setInterval(function(){self.move(0)},self.autoTime))},bind:function(){function touchStart(event){if(self.allowTouch&&(clearInterval(self.timer),spirit=null,event.touches.length)){var touch=event.touches[0];startX=touch.pageX,startY=touch.pageY,ulOffset=parseInt(self.ul.css("left"))}}function touchMove(event){if(event.touches.length){var touch=event.touches[0],x=touch.pageX-startX,y=touch.pageY-startY;event.preventDefault(),Math.abs(x)>Math.abs(y)&&(0>x?(console.log(self.pos),x+=self.pos,spirit=0,self.ul.css("-webkit-transform","translate3d("+x+"px,0,0)")):(x+=self.pos,spirit=1,self.ul.css("-webkit-transform","translate3d("+x+"px,0,0)")))}}function touchEnd(event){0==spirit&&self.move(0),1==spirit&&self.move(1),self.autoPlay()}var startX,startY,ulOffset,self=this,spirit=null;self.wrap[0].addEventListener("touchstart",touchStart,!1),self.wrap[0].addEventListener("touchmove",touchMove,!1),self.wrap[0].addEventListener("touchend",touchEnd,!1)}},$.fn.touchSlide=function(options){var opts=$.extend({},$.fn.touchSlide.defaults,options);this.each(function(){new TouchSlide($(this),opts)})},$.fn.touchSlide.defaults={ul:"ul",li:"li",numBox:".num",cur:"cur",isLoop:!0,isAuto:!0,lazyLoad:!1,imgSrc:"data-src",speed:700,autoTime:5e3}}($)});