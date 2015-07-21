!function($){var ms=$.mobiscroll,defaults={invalid:[],showInput:!0,inputClass:""},preset=function(inst){function setDisabled(dw,nrWheels,whArray,whVector){for(var i=0;nrWheels>i;){var currWh=$(".dwwl"+i,dw),inv=getInvalidKeys(whVector,i,whArray);$.each(inv,function(i,v){$('.dw-li[data-val="'+v+'"]',currWh).removeClass("dw-v")}),i++}}function getInvalidKeys(whVector,index,whArray){for(var n,i=0,whObjA=whArray,invalids=[];index>i;){var ii=whVector[i];for(n in whObjA)if(whObjA[n].key==ii){whObjA=whObjA[n].children;break}i++}for(i=0;i<whObjA.length;)whObjA[i].invalid&&invalids.push(whObjA[i].key),i++;return invalids}function createROVector(n,i){for(var a=[];n;)a[--n]=!0;return a[i]=!1,a}function generateLabels(l){var i,a=[];for(i=0;l>i;i++)a[i]=s.labels&&s.labels[i]?s.labels[i]:i;return a}function generateWheelsFromVector(wv,l,index){var j,obj,chInd,i=0,w=[],wtObjA=wa;if(l)for(j=0;l>j;j++)w[j]=[{}];for(;i<wv.length;){for(w[i]=[getWheelFromObjA(wtObjA,labels[i])],j=0,chInd=void 0;j<wtObjA.length&&void 0===chInd;)wtObjA[j].key==wv[i]&&(void 0!==index&&index>=i||void 0===index)&&(chInd=j),j++;if(void 0!==chInd&&wtObjA[chInd].children)i++,wtObjA=wtObjA[chInd].children;else{if(!(obj=getFirstValidItemObjOrInd(wtObjA))||!obj.children)return w;i++,wtObjA=obj.children}}return w}function getFirstValidItemObjOrInd(wtObjA,getInd){if(!wtObjA)return!1;for(var obj,i=0;i<wtObjA.length;)if(!(obj=wtObjA[i++]).invalid)return getInd?i-1:obj;return!1}function getWheelFromObjA(objA,lbl){for(var wheel={keys:[],values:[],label:lbl},j=0;j<objA.length;)wheel.values.push(objA[j].value),wheel.keys.push(objA[j].key),j++;return wheel}function hideWheels(dw,i){$(".dwc",dw).css("display","").slice(i).hide()}function firstWheelVector(wa){for(var obj,t=[],ndObjA=wa,ok=!0,i=0;ok;)obj=getFirstValidItemObjOrInd(ndObjA),t[i++]=obj.key,ok=obj.children,ok&&(ndObjA=ok);return t}function calcLevelOfVector2(wv,index){var i,childName,chInd,t=[],ndObjA=wa,lvl=0,next=!1;if(void 0!==wv[lvl]&&index>=lvl)for(i=0,childName=wv[lvl],chInd=void 0;i<ndObjA.length&&void 0===chInd;)ndObjA[i].key!=wv[lvl]||ndObjA[i].invalid||(chInd=i),i++;else chInd=getFirstValidItemObjOrInd(ndObjA,!0),childName=ndObjA[chInd].key;for(next=void 0!==chInd?ndObjA[chInd].children:!1,t[lvl]=childName;next;){if(ndObjA=ndObjA[chInd].children,lvl++,next=!1,chInd=void 0,void 0!==wv[lvl]&&index>=lvl)for(i=0,childName=wv[lvl],chInd=void 0;i<ndObjA.length&&void 0===chInd;)ndObjA[i].key!=wv[lvl]||ndObjA[i].invalid||(chInd=i),i++;else chInd=getFirstValidItemObjOrInd(ndObjA,!0),chInd=chInd===!1?void 0:chInd,childName=ndObjA[chInd].key;next=void 0!==chInd&&getFirstValidItemObjOrInd(ndObjA[chInd].children)?ndObjA[chInd].children:!1,t[lvl]=childName}return{lvl:lvl+1,nVector:t}}function createWheelArray(ul){var wheelArray=[];return lvl=lvl>ilvl++?lvl:ilvl,ul.children("li").each(function(index){var that=$(this),c=that.clone();c.children("ul,ol").remove();var v=c.html().replace(/^\s\s*/,"").replace(/\s\s*$/,""),inv=that.data("invalid")?!0:!1,wheelObj={key:that.data("val")||index,value:v,invalid:inv,children:null},nest=that.children("ul,ol");nest.length&&(wheelObj.children=createWheelArray(nest)),wheelArray.push(wheelObj)}),ilvl--,wheelArray}var input,prevent,orig=$.extend({},inst.settings),s=$.extend(inst.settings,defaults,orig),elm=$(this),id=this.id+"_dummy",lvl=0,ilvl=0,timer={},wa=s.wheelArray||createWheelArray(elm),labels=generateLabels(lvl),currWheelVector=[],fwv=firstWheelVector(wa),w=generateWheelsFromVector(fwv,lvl);return $("#"+id).remove(),s.showInput&&(input=$('<input type="text" id="'+id+'" value="" class="'+s.inputClass+'" readonly />').insertBefore(elm),s.anchor=input,inst.attachShow(input)),s.wheelArray||elm.hide().closest(".ui-field-contain").trigger("create"),{width:50,wheels:w,headerText:!1,parseValue:function(value,inst){return s.defaultValue||fwv},onBeforeShow:function(dw){var t=inst.temp;currWheelVector=t.slice(0),s.wheels=generateWheelsFromVector(t,lvl,lvl),prevent=!0},onSelect:function(v,inst){input&&input.val(v),elm.change()},onChange:function(v,inst){inst.live&&(input&&input.val(v),elm.change())},onShow:function(dw){$(".dwwl",dw).on("mousedown touchstart",function(){clearTimeout(timer[$(".dwwl",dw).index(this)])})},onDestroy:function(){input&&input.remove(),elm.show()},validate:function(dw,index,time,manual){var o,args=[],t=inst.temp,i=(index||0)+1;if(void 0!==index&&currWheelVector[index]!=t[index]||void 0===index&&!prevent){for(s.wheels=generateWheelsFromVector(t,null,index),o=calcLevelOfVector2(t,index),void 0!==index&&(inst.temp=o.nVector.slice(0));i<o.lvl;)args.push(i++);if(args.length)return s.readonly=createROVector(lvl,index),clearTimeout(timer[index]),timer[index]=setTimeout(function(){prevent=!0,hideWheels(dw,o.lvl),currWheelVector=inst.temp.slice(0),inst.changeWheel(args,void 0===index?time:0,manual),s.readonly=!1},void 0===index?0:1e3*time),!1;setDisabled(dw,o.lvl,wa,inst.temp)}else o=calcLevelOfVector2(t,t.length),setDisabled(dw,o.lvl,wa,t),hideWheels(dw,o.lvl);prevent=!1}}};$.each(["list","image","treelist"],function(i,v){ms.presets[v]=preset,ms.presetShort(v)})}(jQuery);