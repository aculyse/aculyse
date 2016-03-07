(function(i){function k(F,J,I,H){var G,E,B;I*=p;J*=p;var C=[],D,A,y;I*=-1;D=H.x;A=H.y;y=(H.z===0?0.0001:H.z)*(H.vd||25);y=Math.max(500,y);var w=h(I),z=g(I),t=h(J),m=g(J),x,d,l;i.each(F,function(n){x=n.x-D;d=n.y-A;l=n.z||0;G=z*x-w*l;E=-w*t*x-z*t*l+m*d;B=w*m*x+z*m*l+t*d;G=G*((y-B)/y)+D;E=E*((y-B)/y)+A;C.push({x:j(G),y:j(E),z:j(B)})});return C}function e(d){return d!==void 0&&d!==null}function o(q,v,u,t,r,n,s,l){var m=[];return n>r&&n-r>f/2+0.0001?(m=m.concat(o(q,v,u,t,r,r+f/2,s,l)),m=m.concat(o(q,v,u,t,r+f/2,n,s,l))):n<r&&r-n>f/2+0.0001?(m=m.concat(o(q,v,u,t,r,r-f/2,s,l)),m=m.concat(o(q,v,u,t,r-f/2,n,s,l))):(m=n-r,["C",q+u*g(r)-u*c*m*h(r)+s,v+t*h(r)+t*c*m*g(r)+l,q+u*g(n)+u*c*m*h(n)+s,v+t*h(n)-t*c*m*g(n)+l,q+u*g(n)+s,v+t*h(n)+l])}function a(m){if(this.chart.is3d()){var l=this.chart.options.plotOptions.column.grouping;l!==void 0&&!l&&this.group.zIndex!==void 0&&this.group.attr({zIndex:this.group.zIndex*10});var d=this.options,n=this.options.states;this.borderWidth=d.borderWidth=d.edgeWidth||1;i.each(this.data,function(q){if(q.y!==null){q=q.pointAttr,this.borderColor=i.pick(d.edgeColor,q[""].fill),q[""].stroke=this.borderColor,q.hover.stroke=i.pick(n.hover.edgeColor,this.borderColor),q.select.stroke=i.pick(n.select.edgeColor,this.borderColor)}})}m.apply(this,[].slice.call(arguments,1))}var f=Math.PI,p=f/180,h=Math.sin,g=Math.cos,j=Math.round,c=4*(Math.sqrt(2)-1)/3/(f/2);i.SVGRenderer.prototype.toLinePath=function(m,l){var d=[];i.each(m,function(n){d.push("L",n.x,n.y)});d[0]="M";l&&d.push("Z");return d};i.SVGRenderer.prototype.cuboid=function(l){var d=this.g(),l=this.cuboidPath(l);d.front=this.path(l[0]).attr({zIndex:l[3],"stroke-linejoin":"round"}).add(d);d.top=this.path(l[1]).attr({zIndex:l[4],"stroke-linejoin":"round"}).add(d);d.side=this.path(l[2]).attr({zIndex:l[5],"stroke-linejoin":"round"}).add(d);d.fillSetter=function(m){var q=i.Color(m).brighten(0.1).get(),n=i.Color(m).brighten(-0.1).get();this.front.attr({fill:m});this.top.attr({fill:q});this.side.attr({fill:n});this.color=m;return this};d.opacitySetter=function(m){this.front.attr({opacity:m});this.top.attr({opacity:m});this.side.attr({opacity:m});return this};d.attr=function(m){m.shapeArgs||e(m.x)?(m=this.renderer.cuboidPath(m.shapeArgs||m),this.front.attr({d:m[0],zIndex:m[3]}),this.top.attr({d:m[1],zIndex:m[4]}),this.side.attr({d:m[2],zIndex:m[5]})):i.SVGElement.prototype.attr.call(this,m);return this};d.animate=function(m,q,n){e(m.x)&&e(m.y)?(m=this.renderer.cuboidPath(m),this.front.attr({zIndex:m[3]}).animate({d:m[0]},q,n),this.top.attr({zIndex:m[4]}).animate({d:m[1]},q,n),this.side.attr({zIndex:m[5]}).animate({d:m[2]},q,n)):m.opacity?(this.front.animate(m,q,n),this.top.animate(m,q,n),this.side.animate(m,q,n)):i.SVGElement.prototype.animate.call(this,m,q,n);return this};d.destroy=function(){this.front.destroy();this.top.destroy();this.side.destroy();return null};d.attr({zIndex:-l[3]});return d};i.SVGRenderer.prototype.cuboidPath=function(s){var v=s.x,u=s.y,t=s.z,r=s.height,q=s.width,l=s.depth,m=s.alpha,n=s.beta,v=[{x:v,y:u,z:t},{x:v+q,y:u,z:t},{x:v+q,y:u+r,z:t},{x:v,y:u+r,z:t},{x:v,y:u+r,z:t+l},{x:v+q,y:u+r,z:t+l},{x:v+q,y:u,z:t+l},{x:v,y:u,z:t+l}],v=k(v,m,n,s.origin),s=["M",v[0].x,v[0].y,"L",v[7].x,v[7].y,"L",v[6].x,v[6].y,"L",v[1].x,v[1].y,"Z"],u=["M",v[3].x,v[3].y,"L",v[2].x,v[2].y,"L",v[5].x,v[5].y,"L",v[4].x,v[4].y,"Z"],t=["M",v[1].x,v[1].y,"L",v[2].x,v[2].y,"L",v[5].x,v[5].y,"L",v[6].x,v[6].y,"Z"],r=["M",v[0].x,v[0].y,"L",v[7].x,v[7].y,"L",v[4].x,v[4].y,"L",v[3].x,v[3].y,"Z"];return[["M",v[0].x,v[0].y,"L",v[1].x,v[1].y,"L",v[2].x,v[2].y,"L",v[3].x,v[3].y,"Z"],v[7].y<v[1].y?s:v[4].y>v[2].y?u:[],v[6].x>v[1].x?t:v[7].x<v[0].x?r:[],(v[0].z+v[1].z+v[2].z+v[3].z)/4,n>0?(v[0].z+v[7].z+v[6].z+v[1].z)/4:(v[3].z+v[2].z+v[5].z+v[4].z)/4,m>0?(v[1].z+v[2].z+v[5].z+v[6].z)/4:(v[0].z+v[7].z+v[4].z+v[3].z)/4]};i.SVGRenderer.prototype.arc3d=function(m){m.alpha*=p;m.beta*=p;var l=this.g(),d=this.arc3dPath(m),q=l.renderer,n=d.zTop*100;l.shapeArgs=m;l.top=q.path(d.top).attr({zIndex:d.zTop}).add(l);l.side1=q.path(d.side2).attr({zIndex:d.zSide2});l.side2=q.path(d.side1).attr({zIndex:d.zSide1});l.inn=q.path(d.inn).attr({zIndex:d.zInn});l.out=q.path(d.out).attr({zIndex:d.zOut});l.fillSetter=function(s){this.color=s;var r=i.Color(s).brighten(-0.1).get();this.side1.attr({fill:r});this.side2.attr({fill:r});this.inn.attr({fill:r});this.out.attr({fill:r});this.top.attr({fill:s});return this};l.translateXSetter=function(r){this.out.attr({translateX:r});this.inn.attr({translateX:r});this.side1.attr({translateX:r});this.side2.attr({translateX:r});this.top.attr({translateX:r})};l.translateYSetter=function(r){this.out.attr({translateY:r});this.inn.attr({translateY:r});this.side1.attr({translateY:r});this.side2.attr({translateY:r});this.top.attr({translateY:r})};l.animate=function(s,r,t){e(s.end)||e(s.start)?(this._shapeArgs=this.shapeArgs,i.SVGElement.prototype.animate.call(this,{_args:s},{duration:r,step:function(){var v=arguments[1],u=v.elem,x=u._shapeArgs,w=v.end,v=v.pos,x=i.merge(x,{x:x.x+(w.x-x.x)*v,y:x.y+(w.y-x.y)*v,r:x.r+(w.r-x.r)*v,innerR:x.innerR+(w.innerR-x.innerR)*v,start:x.start+(w.start-x.start)*v,end:x.end+(w.end-x.end)*v}),w=u.renderer.arc3dPath(x);u.shapeArgs=x;u.top.attr({d:w.top,zIndex:w.zTop});u.inn.attr({d:w.inn,zIndex:w.zInn});u.out.attr({d:w.out,zIndex:w.zOut});u.side1.attr({d:w.side1,zIndex:w.zSide1});u.side2.attr({d:w.side2,zIndex:w.zSide2})}},t)):i.SVGElement.prototype.animate.call(this,s,r,t);return this};l.destroy=function(){this.top.destroy();this.out.destroy();this.inn.destroy();this.side1.destroy();this.side2.destroy();i.SVGElement.prototype.destroy.call(this)};l.hide=function(){this.top.hide();this.out.hide();this.inn.hide();this.side1.hide();this.side2.hide()};l.show=function(){this.top.show();this.out.show();this.inn.show();this.side1.show();this.side2.show()};l.zIndex=n;l.attr({zIndex:n});return l};i.SVGRenderer.prototype.arc3dPath=function(J){var M=J.x,L=J.y,K=J.start,I=J.end-0.00001,H=J.r,E=J.innerR,F=J.depth,G=J.alpha,D=J.beta,C=g(K),A=h(K),J=g(I),l=h(I),z=H*g(D),x=H*g(G),B=E*g(D);E*=g(G);var m=F*h(D),n=F*h(G),F=["M",M+z*C,L+x*A],F=F.concat(o(M,L,z,x,K,I,0,0)),F=F.concat(["L",M+B*J,L+E*l]),F=F.concat(o(M,L,B,E,I,K,0,0)),F=F.concat(["Z"]),D=D>0?f/2:0,G=G>0?0:f/2,D=K>-D?K:I>-D?-D:K,w=I<f-G?I:K<f-G?f-G:I,G=["M",M+z*g(D),L+x*h(D)],G=G.concat(o(M,L,z,x,D,w,0,0)),G=G.concat(["L",M+z*g(w)+m,L+x*h(w)+n]),G=G.concat(o(M,L,z,x,w,D,m,n)),G=G.concat(["Z"]),D=["M",M+B*C,L+E*A],D=D.concat(o(M,L,B,E,K,I,0,0)),D=D.concat(["L",M+B*g(I)+m,L+E*h(I)+n]),D=D.concat(o(M,L,B,E,I,K,m,n)),D=D.concat(["Z"]),C=["M",M+z*C,L+x*A,"L",M+z*C+m,L+x*A+n,"L",M+B*C+m,L+E*A+n,"L",M+B*C,L+E*A,"Z"],M=["M",M+z*J,L+x*l,"L",M+z*J+m,L+x*l+n,"L",M+B*J+m,L+E*l+n,"L",M+B*J,L+E*l,"Z"],L=h((K+I)/2),K=h(K),I=h(I);return{top:F,zTop:H,out:G,zOut:Math.max(L,K,I)*H,inn:D,zInn:Math.max(L,K,I)*H,side1:C,zSide1:K*H*0.99,side2:M,zSide2:I*H*0.99}};i.Chart.prototype.is3d=function(){return this.options.chart.options3d&&this.options.chart.options3d.enabled};i.wrap(i.Chart.prototype,"isInsidePlot",function(l){return this.is3d()?!0:l.apply(this,[].slice.call(arguments,1))});i.getOptions().chart.options3d={enabled:!1,alpha:0,beta:0,depth:100,viewDistance:25,frame:{bottom:{size:1,color:"rgba(255,255,255,0)"},side:{size:1,color:"rgba(255,255,255,0)"},back:{size:1,color:"rgba(255,255,255,0)"}}};i.wrap(i.Chart.prototype,"init",function(m){var l=[].slice.call(arguments,1),d;if(l[0].chart.options3d&&l[0].chart.options3d.enabled){d=l[0].plotOptions||{},d=d.pie||{},d.borderColor=i.pick(d.borderColor,void 0)}m.apply(this,l)});i.wrap(i.Chart.prototype,"setChartSize",function(n){n.apply(this,[].slice.call(arguments,1));if(this.is3d()){var m=this.inverted,l=this.clipBox,q=this.margin;l[m?"y":"x"]=-(q[3]||0);l[m?"x":"y"]=-(q[0]||0);l[m?"height":"width"]=this.chartWidth+(q[3]||0)+(q[1]||0);l[m?"width":"height"]=this.chartHeight+(q[0]||0)+(q[2]||0)}});i.wrap(i.Chart.prototype,"redraw",function(l){if(this.is3d()){this.isDirtyBox=!0}l.apply(this,[].slice.call(arguments,1))});i.Chart.prototype.retrieveStacks=function(m,l){var d={},n=1;if(m||!l){return this.series}i.each(this.series,function(q){d[q.options.stack||0]?d[q.options.stack||0].series.push(q):(d[q.options.stack||0]={series:[q],position:n},n++)});d.totalStacks=n+1;return d};i.wrap(i.Axis.prototype,"init",function(l){var d=arguments;if(d[1].is3d()){d[2].tickWidth=i.pick(d[2].tickWidth,0),d[2].gridLineWidth=i.pick(d[2].gridLineWidth,1)}l.apply(this,[].slice.call(arguments,1))});i.wrap(i.Axis.prototype,"render",function(C){C.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){var F=this.chart,E=F.renderer,D=F.options.chart.options3d,B=D.alpha,A=D.beta*(F.yAxis[0].opposite?-1:1),x=D.frame,y=x.bottom,z=x.back,x=x.side,w=D.depth,s=this.height,r=this.width,v=this.left,u=this.top,D={x:F.plotLeft+F.plotWidth/2,y:F.plotTop+F.plotHeight/2,z:w,vd:D.viewDistance};if(this.horiz){this.axisLine&&this.axisLine.hide(),A={x:v,y:u+(F.yAxis[0].reversed?-y.size:s),z:0,width:r,height:y.size,depth:w,alpha:B,beta:A,origin:D},this.bottomFrame?this.bottomFrame.animate(A):this.bottomFrame=E.cuboid(A).attr({fill:y.color,zIndex:F.yAxis[0].reversed&&B>0?4:-1}).css({stroke:y.color}).add()}else{var t={x:v,y:u,z:w+1,width:r,height:s+y.size,depth:z.size,alpha:B,beta:A,origin:D};this.backFrame?this.backFrame.animate(t):this.backFrame=E.cuboid(t).attr({fill:z.color,zIndex:-3}).css({stroke:z.color}).add();this.axisLine&&this.axisLine.hide();F={x:(F.yAxis[0].opposite?r:0)+v-x.size,y:u,z:0,width:x.size,height:s+y.size,depth:w+z.size,alpha:B,beta:A,origin:D};this.sideFrame?this.sideFrame.animate(F):this.sideFrame=E.cuboid(F).attr({fill:x.color,zIndex:-2}).css({stroke:x.color}).add()}}});i.wrap(i.Axis.prototype,"getPlotLinePath",function(r){var m=r.apply(this,[].slice.call(arguments,1));if(!this.chart.is3d()){return m}if(m===null){return m}var l=this.chart,s=l.options.chart.options3d,q=s.depth;s.origin={x:l.plotLeft+l.plotWidth/2,y:l.plotTop+l.plotHeight/2,z:q,vd:s.viewDistance};var m=[{x:m[1],y:m[2],z:this.horiz||this.opposite?q:0},{x:m[1],y:m[2],z:q},{x:m[4],y:m[5],z:q},{x:m[4],y:m[5],z:this.horiz||this.opposite?0:q}],q=l.options.inverted?s.beta:s.alpha,n=l.options.inverted?s.alpha:s.beta;n*=l.yAxis[0].opposite?-1:1;m=k(m,q,n,s.origin);return m=this.chart.renderer.toLinePath(m,!1)});i.wrap(i.Axis.prototype,"getPlotBandPath",function(n){if(this.chart.is3d()){var m=arguments,l=m[1],m=this.getPlotLinePath(m[2]);(l=this.getPlotLinePath(l))&&m?l.push(m[7],m[8],m[4],m[5],m[1],m[2]):l=null;return l}else{return n.apply(this,[].slice.call(arguments,1))}});i.wrap(i.Tick.prototype,"getMarkPath",function(r){var m=r.apply(this,[].slice.call(arguments,1));if(!this.axis.chart.is3d()){return m}var l=this.axis.chart,s=l.options.chart.options3d,q={x:l.plotLeft+l.plotWidth/2,y:l.plotTop+l.plotHeight/2,z:s.depth,vd:s.viewDistance},m=[{x:m[1],y:m[2],z:0},{x:m[4],y:m[5],z:0}],n=l.inverted?s.beta:s.alpha,s=l.inverted?s.alpha:s.beta;s*=l.yAxis[0].opposite?-1:1;m=k(m,n,s,q);return m=["M",m[0].x,m[0].y,"L",m[1].x,m[1].y]});i.wrap(i.Tick.prototype,"getLabelPosition",function(r){var m=r.apply(this,[].slice.call(arguments,1));if(!this.axis.chart.is3d()){return m}var l=this.axis.chart,s=l.options.chart.options3d,q={x:l.plotLeft+l.plotWidth/2,y:l.plotTop+l.plotHeight/2,z:s.depth,vd:s.viewDistance},n=l.inverted?s.beta:s.alpha,s=l.inverted?s.alpha:s.beta;s*=l.yAxis[0].opposite?-1:1;return m=k([{x:m.x,y:m.y,z:0}],n,s,q)[0]});i.wrap(i.Axis.prototype,"drawCrosshair",function(m){var l=arguments;this.chart.is3d()&&l[2]&&(l[2]={plotX:l[2].plotXold||l[2].plotX,plotY:l[2].plotYold||l[2].plotY});m.apply(this,[].slice.call(l,1))});i.wrap(i.seriesTypes.column.prototype,"translate",function(q){q.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){var u=this.chart,t=this.options,s=u.options.chart.options3d,r=t.depth||25,n={x:u.plotWidth/2,y:u.plotHeight/2,z:s.depth,vd:s.viewDistance},d=s.alpha,l=s.beta*(u.yAxis[0].opposite?-1:1),m=(t.stacking?t.stack||0:this._i)*(r+(t.groupZPadding||1));t.grouping!==!1&&(m=0);m+=t.groupZPadding||1;i.each(this.data,function(w){if(w.y!==null){var v=w.shapeArgs,x=w.tooltipPos;w.shapeType="cuboid";v.alpha=d;v.beta=l;v.z=m;v.origin=n;v.depth=r;x=k([{x:x[0],y:x[1],z:m}],d,l,n)[0];w.tooltipPos=[x.x,x.y]}})}});i.wrap(i.seriesTypes.column.prototype,"animate",function(m){if(this.chart.is3d()){var l=arguments[1],d=this.yAxis,q=this,n=this.yAxis.reversed;if(i.svg){l?i.each(q.data,function(r){if(r.y!==null&&(r.height=r.shapeArgs.height,r.shapey=r.shapeArgs.y,r.shapeArgs.height=1,!n)){r.shapeArgs.y=r.stackY?r.plotY+d.translate(r.stackY):r.plotY+(r.negative?-r.height:r.height)}}):(i.each(q.data,function(r){if(r.y!==null){r.shapeArgs.height=r.height,r.shapeArgs.y=r.shapey,r.graphic&&r.graphic.animate(r.shapeArgs,q.options.animation)}}),this.drawDataLabels(),q.animate=null)}}else{m.apply(this,[].slice.call(arguments,1))}});i.wrap(i.seriesTypes.column.prototype,"init",function(q){q.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){var m=this.options,l=m.grouping,r=m.stacking,n=0;if((l===void 0||l)&&r){l=this.chart.retrieveStacks(l,r);r=m.stack||0;for(n=0;n<l[r].series.length;n++){if(l[r].series[n]===this){break}}n=l.totalStacks*10-10*(l.totalStacks-l[r].position)-n}m.zIndex=n}});i.wrap(i.Series.prototype,"alignDataLabel",function(q){if(this.chart.is3d()&&(this.type==="column"||this.type==="columnrange")){var m=this.chart,l=m.options.chart.options3d,r=arguments[4],n={x:r.x,y:r.y,z:0},n=k([n],l.alpha,l.beta*(m.yAxis[0].opposite?-1:1),{x:m.plotWidth/2,y:m.plotHeight/2,z:l.depth,vd:l.viewDistance})[0];r.x=n.x;r.y=n.y}q.apply(this,[].slice.call(arguments,1))});i.seriesTypes.columnrange&&i.wrap(i.seriesTypes.columnrange.prototype,"drawPoints",a);i.wrap(i.seriesTypes.column.prototype,"drawPoints",a);var b=i.getOptions();b.plotOptions.cylinder=i.merge(b.plotOptions.column);b=i.extendClass(i.seriesTypes.column,{type:"cylinder"});i.seriesTypes.cylinder=b;i.wrap(i.seriesTypes.cylinder.prototype,"translate",function(r){r.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){var l=this.chart,d=l.options,t=d.plotOptions.cylinder,d=d.chart.options3d,s=t.depth||0,q={x:l.inverted?l.plotHeight/2:l.plotWidth/2,y:l.inverted?l.plotWidth/2:l.plotHeight/2,z:d.depth,vd:d.viewDistance},m=d.alpha,n=t.stacking?(this.options.stack||0)*s:this._i*s;n+=s/2;t.grouping!==!1&&(n=0);i.each(this.data,function(v){var u=v.shapeArgs;v.shapeType="arc3d";u.x+=s/2;u.z=n;u.start=0;u.end=2*f;u.r=s*0.95;u.innerR=0;u.depth=u.height*(1/h((90-m)*p))-n;u.alpha=90-m;u.beta=0;u.origin=q})}});i.wrap(i.seriesTypes.pie.prototype,"translate",function(r){r.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){var v=this,u=v.chart,t=v.options,s=t.depth||0,q=u.options.chart.options3d,l={x:u.plotWidth/2,y:u.plotHeight/2,z:q.depth},m=q.alpha,n=q.beta,d=t.stacking?(t.stack||0)*s:v._i*s;d+=s/2;t.grouping!==!1&&(d=0);i.each(v.data,function(w){w.shapeType="arc3d";var x=w.shapeArgs;if(w.y){x.z=d,x.depth=s*0.75,x.origin=l,x.alpha=m,x.beta=n,x=(x.end+x.start)/2,w.slicedTranslation={translateX:j(g(x)*v.options.slicedOffset*g(m*p)),translateY:j(h(x)*v.options.slicedOffset*g(m*p))}}})}});i.wrap(i.seriesTypes.pie.prototype.pointClass.prototype,"haloPath",function(m){var l=arguments;return this.series.chart.is3d()?[]:m.call(this,l[1])});i.wrap(i.seriesTypes.pie.prototype,"drawPoints",function(m){if(this.chart.is3d()){var l=this.options,d=this.options.states;this.borderWidth=l.borderWidth=l.edgeWidth||1;this.borderColor=l.edgeColor=i.pick(l.edgeColor,l.borderColor,void 0);d.hover.borderColor=i.pick(d.hover.edgeColor,this.borderColor);d.hover.borderWidth=i.pick(d.hover.edgeWidth,this.borderWidth);d.select.borderColor=i.pick(d.select.edgeColor,this.borderColor);d.select.borderWidth=i.pick(d.select.edgeWidth,this.borderWidth);i.each(this.data,function(q){var r=q.pointAttr;r[""].stroke=q.series.borderColor||q.color;r[""]["stroke-width"]=q.series.borderWidth;r.hover.stroke=d.hover.borderColor;r.hover["stroke-width"]=d.hover.borderWidth;r.select.stroke=d.select.borderColor;r.select["stroke-width"]=d.select.borderWidth})}m.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){var n=this.group;i.each(this.points,function(q){q.graphic.out.add(n);q.graphic.inn.add(n);q.graphic.side1.add(n);q.graphic.side2.add(n)})}});i.wrap(i.seriesTypes.pie.prototype,"drawDataLabels",function(d){this.chart.is3d()&&i.each(this.data,function(m){var l=m.shapeArgs,r=l.r,q=l.depth,n=l.alpha*p,l=(l.start+l.end)/2,m=m.labelPos;m[1]+=-r*(1-g(n))*h(l)+(h(l)>0?h(n)*q:0);m[3]+=-r*(1-g(n))*h(l)+(h(l)>0?h(n)*q:0);m[5]+=-r*(1-g(n))*h(l)+(h(l)>0?h(n)*q:0)});d.apply(this,[].slice.call(arguments,1))});i.wrap(i.seriesTypes.pie.prototype,"addPoint",function(l){l.apply(this,[].slice.call(arguments,1));this.chart.is3d()&&this.update()});i.wrap(i.seriesTypes.pie.prototype,"animate",function(n){if(this.chart.is3d()){var l=arguments[1],d=this.options.animation,r=this.center,q=this.group,m=this.markerGroup;if(i.svg){if(d===!0&&(d={}),l){if(q.oldtranslateX=q.translateX,q.oldtranslateY=q.translateY,l={translateX:r[0],translateY:r[1],scaleX:0.001,scaleY:0.001},q.attr(l),m){m.attrSetters=q.attrSetters,m.attr(l)}}else{l={translateX:q.oldtranslateX,translateY:q.oldtranslateY,scaleX:1,scaleY:1},q.animate(l,d),m&&m.animate(l,d),this.animate=null}}}else{n.apply(this,[].slice.call(arguments,1))}});i.wrap(i.seriesTypes.scatter.prototype,"translate",function(r){r.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){var l=this.chart,d=this.chart.options.chart.options3d,t=d.alpha,s=d.beta,q={x:l.inverted?l.plotHeight/2:l.plotWidth/2,y:l.inverted?l.plotWidth/2:l.plotHeight/2,z:d.depth,vd:d.viewDistance},d=d.depth,m=l.options.zAxis||{min:0,max:d},n=d/(m.max-m.min);i.each(this.data,function(v){var u={x:v.plotX,y:v.plotY,z:(v.z-m.min)*n},u=k([u],t,s,q)[0];v.plotXold=v.plotX;v.plotYold=v.plotY;v.plotX=u.x;v.plotY=u.y;v.plotZ=u.z})}});i.wrap(i.seriesTypes.scatter.prototype,"init",function(m){var l=m.apply(this,[].slice.call(arguments,1));if(this.chart.is3d()){this.pointArrayMap=["x","y","z"],this.tooltipOptions.pointFormat=this.userOptions.tooltip?this.userOptions.tooltip.pointFormat||"x: <b>{point.x}</b><br/>y: <b>{point.y}</b><br/>z: <b>{point.z}</b><br/>":"x: <b>{point.x}</b><br/>y: <b>{point.y}</b><br/>z: <b>{point.z}</b><br/>"}return l});if(i.VMLRenderer){i.setOptions({animate:!1}),i.VMLRenderer.prototype.cuboid=i.SVGRenderer.prototype.cuboid,i.VMLRenderer.prototype.cuboidPath=i.SVGRenderer.prototype.cuboidPath,i.VMLRenderer.prototype.toLinePath=i.SVGRenderer.prototype.toLinePath,i.VMLRenderer.prototype.createElement3D=i.SVGRenderer.prototype.createElement3D,i.VMLRenderer.prototype.arc3d=function(d){d=i.SVGRenderer.prototype.arc3d.call(this,d);d.css({zIndex:d.zIndex});return d},i.VMLRenderer.prototype.arc3dPath=i.SVGRenderer.prototype.arc3dPath,i.Chart.prototype.renderSeries=function(){for(var m,l=this.series.length;l--;){m=this.series[l],m.translate(),m.setTooltipPoints&&m.setTooltipPoints(),m.render()}},i.wrap(i.Axis.prototype,"render",function(l){l.apply(this,[].slice.call(arguments,1));this.sideFrame&&(this.sideFrame.css({zIndex:0}),this.sideFrame.front.attr({fill:this.sideFrame.color}));this.bottomFrame&&(this.bottomFrame.css({zIndex:1}),this.bottomFrame.front.attr({fill:this.bottomFrame.color}));this.backFrame&&(this.backFrame.css({zIndex:0}),this.backFrame.front.attr({fill:this.backFrame.color}))})}})(Highcharts);
/*Size: 19505->19392Bytes 
 Saved 0.57933927%*/