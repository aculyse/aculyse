(function(){var a=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(c){setTimeout(c,1000/60)},b=window.Circles=function(e){var d=e.id;this._el=document.getElementById(d);if(this._el===null){return}this._radius=e.radius||10;this._duration=e.duration===undefined?500:e.duration;this._value=0;this._maxValue=e.maxValue||100;this._text=e.text===undefined?function(f){return this.htmlifyNumber(f)}:e.text;this._strokeWidth=e.width||10;this._colors=e.colors||["#E6E9ED","#DA4453"];this._svg=null;this._movingPath=null;this._wrapContainer=null;this._textContainer=null;this._wrpClass=e.wrpClass||"circles-wrp";this._textClass=e.textClass||"circles-text";var c=Math.PI/180*270;this._start=-Math.PI/180*90;this._startPrecise=this._precise(this._start);this._circ=c-this._start;this._generate().update(e.value||0)};b.prototype={VERSION:"0.0.5",_generate:function(){this._svgSize=this._radius*2;this._radiusAdjusted=this._radius-(this._strokeWidth/2);this._generateSvg()._generateText()._generateWrapper();this._el.innerHTML="";this._el.appendChild(this._wrapContainer);return this},_setPercentage:function(c){this._movingPath.setAttribute("d",this._calculatePath(c,true));this._textContainer.innerHTML=this._getText(this.getValueFromPercent(c))},_generateWrapper:function(){this._wrapContainer=document.createElement("div");this._wrapContainer.className=this._wrpClass;this._wrapContainer.style.position="relative";this._wrapContainer.style.display="inline-block";this._wrapContainer.appendChild(this._svg);this._wrapContainer.appendChild(this._textContainer);return this},_generateText:function(){this._textContainer=document.createElement("div");this._textContainer.className=this._textClass;var c={position:"absolute",top:0,left:0,textAlign:"center",width:"100%",fontSize:(this._radius*0.7)+"px",height:this._svgSize+"px",lineHeight:this._svgSize+"px",textShadow:"0 0 4px"};for(var d in c){this._textContainer.style[d]=c[d]}this._textContainer.innerHTML=this._getText(0);return this},_getText:function(c){if(!this._text){return""}if(c===undefined){c=this._value}c=parseFloat(c.toFixed(2));return typeof this._text==="function"?this._text.call(this,c):this._text},_generateSvg:function(){this._svg=document.createElementNS("http://www.w3.org/2000/svg","svg");this._svg.setAttribute("xmlns","http://www.w3.org/2000/svg");this._svg.setAttribute("width",this._svgSize);this._svg.setAttribute("height",this._svgSize);this._generatePath(100,false,this._colors[0])._generatePath(1,true,this._colors[1]);this._movingPath=this._svg.getElementsByTagName("path")[1];return this},_generatePath:function(c,e,d){var f=document.createElementNS("http://www.w3.org/2000/svg","path");f.setAttribute("fill","transparent");f.setAttribute("stroke",d);f.setAttribute("stroke-width",30);f.setAttribute("d",this._calculatePath(c,e));this._svg.appendChild(f);return this},_calculatePath:function(e,f){var d=this._start+((e/100)*this._circ),c=this._precise(d);return this._arc(c,f)},_arc:function(c,d){var f=c-0.001,e=c-this._startPrecise<Math.PI?0:1;return["M",this._radius+this._radiusAdjusted*Math.cos(this._startPrecise),this._radius+this._radiusAdjusted*Math.sin(this._startPrecise),"A",this._radiusAdjusted,this._radiusAdjusted,0,e,1,this._radius+this._radiusAdjusted*Math.cos(f),this._radius+this._radiusAdjusted*Math.sin(f),d?"":"Z"].join(" ")},_precise:function(c){return Math.round(c*1000)/1000},htmlifyNumber:function(e,c,f){c=c||"circles-integer";f=f||"circles-decimals";var g=(e+"").split("."),d='<span class="'+c+'">'+g[0]+"</span>";if(g.length>1){d+='.<span class="'+f+'">'+g[1].substring(0,2)+"%</span>"}else{d+='.<span class="'+f+'">00%</span>'}return d},updateRadius:function(c){this._radius=c;return this._generate().update(true)},updateWidth:function(c){this._strokeWidth=c;return this._generate().update(true)},updateColors:function(c){this._colors=c;var d=this._svg.getElementsByTagName("path");d[0].setAttribute("stroke",c[0]);d[1].setAttribute("stroke",c[1]);return this},getPercent:function(){return(this._value*100)/this._maxValue},getValueFromPercent:function(c){return(this._maxValue*c)/100},getValue:function(){return this._value},getMaxValue:function(){return this._maxValue},update:function(j,e){if(j===true){this._setPercentage(this.getPercent());return this}if(this._value==j||isNaN(j)){return this}if(e===undefined){e=this._duration}var l=this,g=l.getPercent(),k=1,h,d,i,f;this._value=Math.min(this._maxValue,Math.max(0,j));if(!e){this._setPercentage(this.getPercent());return this}h=l.getPercent();d=h>g;k+=h%1;i=Math.floor(Math.abs(h-g)/k);f=e/i;(function c(o){if(d){g+=k}else{g-=k}if((d&&g>=h)||(!d&&g<=h)){a(function(){l._setPercentage(h)});return}a(function(){l._setPercentage(g)});var n=Date.now(),m=n-o;if(m>=f){c(n)}else{setTimeout(function(){c(Date.now())},f-m)}})(Date.now());return this}};b.create=function(c){return new b(c)}})();
/*Size: 11056->4964Bytes 
 Saved 55.1013%*/