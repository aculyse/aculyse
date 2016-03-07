(function(a,b){if(typeof define==="function"&&define.amd){define(["jquery"],b)}else{if(typeof exports==="object"){module.exports=b(require("jquery"))}else{b(a.jQuery)}}})(this,function(G){G.transit={version:"0.9.12",propertyMap:{marginLeft:"margin",marginRight:"margin",marginBottom:"margin",marginTop:"margin",paddingLeft:"padding",paddingRight:"padding",paddingBottom:"padding",paddingTop:"padding"},enabled:true,useTransitionEnd:false};var z=document.createElement("div");var m={};function v(b){if(b in z.style){return b}var e=["Moz","Webkit","O","ms"];var a=b.charAt(0).toUpperCase()+b.substr(1);for(var d=0;d<e.length;++d){var c=e[d]+a;if(c in z.style){return c}}}function g(){z.style[m.transform]="";z.style[m.transform]="rotateY(90deg)";return z.style[m.transform]!==""}var H=navigator.userAgent.toLowerCase().indexOf("chrome")>-1;m.transition=v("transition");m.transitionDelay=v("transitionDelay");m.transform=v("transform");m.transformOrigin=v("transformOrigin");m.filter=v("Filter");m.transform3d=g();var E={transition:"transitionend",MozTransition:"transitionend",OTransition:"oTransitionEnd",WebkitTransition:"webkitTransitionEnd",msTransition:"MSTransitionEnd"};var k=m.transitionEnd=E[m.transition]||null;for(var F in m){if(m.hasOwnProperty(F)&&typeof G.support[F]==="undefined"){G.support[F]=m[F]}}z=null;G.cssEase={_default:"ease","in":"ease-in",out:"ease-out","in-out":"ease-in-out",snap:"cubic-bezier(0,1,.5,1)",easeInCubic:"cubic-bezier(.550,.055,.675,.190)",easeOutCubic:"cubic-bezier(.215,.61,.355,1)",easeInOutCubic:"cubic-bezier(.645,.045,.355,1)",easeInCirc:"cubic-bezier(.6,.04,.98,.335)",easeOutCirc:"cubic-bezier(.075,.82,.165,1)",easeInOutCirc:"cubic-bezier(.785,.135,.15,.86)",easeInExpo:"cubic-bezier(.95,.05,.795,.035)",easeOutExpo:"cubic-bezier(.19,1,.22,1)",easeInOutExpo:"cubic-bezier(1,0,0,1)",easeInQuad:"cubic-bezier(.55,.085,.68,.53)",easeOutQuad:"cubic-bezier(.25,.46,.45,.94)",easeInOutQuad:"cubic-bezier(.455,.03,.515,.955)",easeInQuart:"cubic-bezier(.895,.03,.685,.22)",easeOutQuart:"cubic-bezier(.165,.84,.44,1)",easeInOutQuart:"cubic-bezier(.77,0,.175,1)",easeInQuint:"cubic-bezier(.755,.05,.855,.06)",easeOutQuint:"cubic-bezier(.23,1,.32,1)",easeInOutQuint:"cubic-bezier(.86,0,.07,1)",easeInSine:"cubic-bezier(.47,0,.745,.715)",easeOutSine:"cubic-bezier(.39,.575,.565,1)",easeInOutSine:"cubic-bezier(.445,.05,.55,.95)",easeInBack:"cubic-bezier(.6,-.28,.735,.045)",easeOutBack:"cubic-bezier(.175, .885,.32,1.275)",easeInOutBack:"cubic-bezier(.68,-.55,.265,1.55)"};G.cssHooks["transit:transform"]={get:function(a){return G(a).data("transform")||new x},set:function(c,a){var b=a;if(!(b instanceof x)){b=new x(b)}if(m.transform==="WebkitTransform"&&!H){c.style[m.transform]=b.toString(true)}else{c.style[m.transform]=b.toString()}G(c).data("transform",b)}};G.cssHooks.transform={set:G.cssHooks["transit:transform"].set};G.cssHooks.filter={get:function(a){return a.style[m.filter]},set:function(a,b){a.style[m.filter]=b}};if(G.fn.jquery<"1.8"){G.cssHooks.transformOrigin={get:function(a){return a.style[m.transformOrigin]},set:function(a,b){a.style[m.transformOrigin]=b}};G.cssHooks.transition={get:function(a){return a.style[m.transition]},set:function(a,b){a.style[m.transition]=b}}}j("scale");j("scaleX");j("scaleY");j("translate");j("rotate");j("rotateX");j("rotateY");j("rotate3d");j("perspective");j("skewX");j("skewY");j("x",true);j("y",true);function x(a){if(typeof a==="string"){this.parse(a)}return this}x.prototype={setFromString:function(a,b){var c=typeof b==="string"?b.split(","):b.constructor===Array?b:[b];c.unshift(a);x.prototype.set.apply(this,c)},set:function(a){var b=Array.prototype.slice.apply(arguments,[1]);if(this.setter[a]){this.setter[a].apply(this,b)}else{this[a]=b.join(",")}},get:function(a){if(this.getter[a]){return this.getter[a].apply(this)}else{return this[a]||0}},setter:{rotate:function(a){this.rotate=D(a,"deg")},rotateX:function(a){this.rotateX=D(a,"deg")},rotateY:function(a){this.rotateY=D(a,"deg")},scale:function(a,b){if(b===undefined){b=a}this.scale=a+","+b},skewX:function(a){this.skewX=D(a,"deg")},skewY:function(a){this.skewY=D(a,"deg")},perspective:function(a){this.perspective=D(a,"px")},x:function(a){this.set("translate",a,null)},y:function(a){this.set("translate",null,a)},translate:function(a,b){if(this._translateX===undefined){this._translateX=0}if(this._translateY===undefined){this._translateY=0}if(a!==null&&a!==undefined){this._translateX=D(a,"px")}if(b!==null&&b!==undefined){this._translateY=D(b,"px")}this.translate=this._translateX+","+this._translateY}},getter:{x:function(){return this._translateX||0},y:function(){return this._translateY||0},scale:function(){var a=(this.scale||"1,1").split(",");if(a[0]){a[0]=parseFloat(a[0])}if(a[1]){a[1]=parseFloat(a[1])}return a[0]===a[1]?a[0]:a},rotate3d:function(){var a=(this.rotate3d||"0,0,0,0deg").split(",");for(var b=0;b<=3;++b){if(a[b]){a[b]=parseFloat(a[b])}}if(a[3]){a[3]=D(a[3],"deg")}return a}},parse:function(a){var b=this;a.replace(/([a-zA-Z0-9]+)\((.*?)\)/g,function(d,e,c){b.setFromString(e,c)})},toString:function(b){var c=[];for(var a in this){if(this.hasOwnProperty(a)){if(!m.transform3d&&(a==="rotateX"||a==="rotateY"||a==="perspective"||a==="transformOrigin")){continue}if(a[0]!=="_"){if(b&&a==="scale"){c.push(a+"3d("+this[a]+",1)")}else{if(b&&a==="translate"){c.push(a+"3d("+this[a]+",0)")}else{c.push(a+"("+this[a]+")")}}}}}return c.join(" ")}};function B(a,b,c){if(b===true){a.queue(c)}else{if(b){a.queue(b,c)}else{a.each(function(){c.call(this)})}}}function q(b){var a=[];G.each(b,function(c){c=G.camelCase(c);c=G.transit.propertyMap[c]||G.cssProps[c]||c;c=w(c);if(m[c]){c=w(m[c])}if(G.inArray(c,a)===-1){a.push(c)}});return a}function A(h,p,c,f){var d=q(h);if(G.cssEase[c]){c=G.cssEase[c]}var b=""+C(p)+" "+c;if(parseInt(f,10)>0){b+=" "+C(f)}var l=[];G.each(d,function(a,i){l.push(i+" "+b)});return l.join(", ")}G.fn.transition=G.fn.transit=function(K,t,c,Q){var N=this;var P=0;var J=true;var o=G.extend(true,{},K);if(typeof t==="function"){Q=t;t=undefined}if(typeof t==="object"){c=t.easing;P=t.delay||0;J=typeof t.queue==="undefined"?true:t.queue;Q=t.complete;t=t.duration}if(typeof c==="function"){Q=c;c=undefined}if(typeof o.easing!=="undefined"){c=o.easing;delete o.easing}if(typeof o.duration!=="undefined"){t=o.duration;delete o.duration}if(typeof o.complete!=="undefined"){Q=o.complete;delete o.complete}if(typeof o.queue!=="undefined"){J=o.queue;delete o.queue}if(typeof o.delay!=="undefined"){P=o.delay;delete o.delay}if(typeof t==="undefined"){t=G.fx.speeds._default}if(typeof c==="undefined"){c=G.cssEase._default}t=C(t);var d=A(o,t,c,P);var y=G.transit.enabled&&m.transition;var M=y?parseInt(t,10)+parseInt(P,10):0;if(M===0){var I=function(a){N.css(o);if(Q){Q.apply(N)}if(a){a()}};B(N,J,I);return N}var n={};var O=function(f){var a=false;var b=function(){if(a){N.unbind(k,b)}if(M>0){N.each(function(){this.style[m.transition]=n[this]||null})}if(typeof Q==="function"){Q.apply(N)}if(typeof f==="function"){f()}};if(M>0&&k&&G.transit.useTransitionEnd){a=true;N.bind(k,b)}else{window.setTimeout(b,M)}N.each(function(){if(M>0){this.style[m.transition]=d}G(this).css(o)})};var L=function(a){this.offsetWidth;O(a)};B(N,J,L);return this};function j(b,a){if(!a){G.cssNumber[b]=true}G.transit.propertyMap[b]=m.transform;G.cssHooks[b]={get:function(d){var c=G(d).css("transit:transform");return c.get(b)},set:function(e,c){var d=G(e).css("transit:transform");d.setFromString(b,c);G(e).css({"transit:transform":d})}}}function w(a){return a.replace(/([A-Z])/g,function(b){return"-"+b.toLowerCase()})}function D(a,b){if(typeof a==="string"&&!a.match(/^[\-0-9\.]+$/)){return a}else{return""+a+b}}function C(a){var b=a;if(typeof b==="string"&&!b.match(/^[\-0-9\.]+/)){b=G.fx.speeds[b]||G.fx.speeds._default}return D(b,"ms")}G.transit.getTransitionValue=A;return G});
/*Size: 7830->7835Bytes 
 Saved -0.06386042%*/