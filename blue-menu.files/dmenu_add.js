//***********************************************
//  Javascript Menu (c) 2006 - 2009, by Deluxe-Menu.com
//  Trial Version
//
//  version 3.10
//  E-mail:  cs@deluxe-menu.com
//***********************************************

//***********************************************
// Obfuscated by Javascript Obfuscator
// http://javascript-source.com
//***********************************************

var d_yum=null;
if(d_ec){
	d_o.onselectstart=function(){
		return d_dmr.d_dvi?false:true;
	};
}

function _dmyx(e){
	with(e){
		return[d_e||d_oo?clientX:pageX,d_e||d_oo?clientY:pageY];
	}
}

function _dmis(d_o1){
	return[parseInt(d_o1.style.left),parseInt(d_o1.style.top)];
}

function _dmbe(e,d_gcm){
	with(d_dmr){
		if(!d_dl||d_dvi){
			return;
		}
		d_co=_dmoi(d_gcm);
		var d_mii=_dmyx(e);
		var mXY=dengine._dmos(d_co);
		var d_po=d_ec?_dmps():[0,0];
		cX=d_mii[0]-mXY[0]+d_po[0];
		cY=d_mii[1]-mXY[1]+d_po[1];
		d_ce=_dmvi(d_gcm);
		d_dvi=true;
	}
}

function _dmse(){
	with(d_dmr){
		if(!d_dl||!d_dvi){
			return;
		}
		var d_po=_dmps();
		var mXY=_dmis(d_co);
		d_ce.left=mXY[0]-d_po[0];
		d_ce.top=mXY[1]-d_po[1];
		d_dvi=false;
	}
}

function _dmo(event){
	if(d_dmr.d_dvi&&d_dl){
		var d_mii=_dmyx(event);
		var d_po=d_ec?_dmps():[0,0];
		var d_nq=d_mii[0]-d_dmr.cX+d_po[0];
		var d_ne=d_mii[1]-d_dmr.cY+d_po[1];
		with(d_dmr){
			d_co.style.left=(d_nq>=0?d_nq:0)+"px";
			d_co.style.top=(d_ne>=0?d_ne:0)+"px";
			d_ce.d_ddv=1;_dmfa(d_co);
			if(dmObjectsCheck){
				_dmzz(d_ce);
				_dmi(d_ce,dengine._dmos(d_co));
			}
		}
	}
	return true;
}

function _dmm(){
	if(document.attachEvent){
		document.attachEvent("onmousemove",_dmo);
	}else{
		d_yum=document.onmousemove;document.onmousemove=function(e){
			_dmo(d_em?window.event:e);
			if(d_yum){
				d_yum(e);
			}
			return true;
		};
	}
}

function _dmps(){
	var x=0,y=0;
	with(window.document){
		if(documentElement&&documentElement.scrollLeft){
			x=documentElement.scrollLeft;
		}else if(body&&body.scrollLeft){
			x=body.scrollLeft;
		}
		if(documentElement&&documentElement.scrollTop){
			y=documentElement.scrollTop;
		}else if(body&&body.scrollTop){
			y=body.scrollTop;
		}
	}
	return[x,y];
}

function _dmyr(){
	if(d_dmr.d_dvi){
		return;
	}
	for(var i=0;i<d_dm.length;i++){
		if(d_dm[i]){
			with(d_dm[i]){
				if(flt){
					var d_mo=_dmoi(m[0].id);
					var mXY=dengine._dmos(d_mo);
					var offXY=_dmis(d_mo);
					offXY[0]=mXY[0]-offXY[0];
					offXY[1]=mXY[1]-offXY[1];
					var d_po=_dmps();
					if(fltX){
						if(flt==1){
							var x=_dmO1(d_po[0],d_po[2],parseInt(m[0].left)+offXY[0],0,mXY[2],1,1,fltDX).xy;
						}else if(flt==2){
							var x=d_po[0]+parseInt(m[0].left)+offXY[0];
						}
						if(x!=mXY[0]){
							var dx=(x-mXY[0])/fltIter;
							with(Math){
								if(abs(dx)<1){
									dx=abs(dx)/dx;
								}
							}
							d_mo.style.left=parseInt(mXY[0]+(mXY[0]!=x?dx:0))-offXY[0]+"px";
						}
					}
					if(fltY){
						if(flt==1){
							var y=_dmO1(d_po[1],d_po[3],parseInt(m[0].top)+offXY[1],0,mXY[3],1,1,fltDY).xy;
						}else if(flt==2){
							var y=d_po[1]+parseInt(m[0].top)+offXY[1];
						}
						if(y!=mXY[1]){
							var dy=(y-mXY[1])/fltIter;
							with(Math){
								if(abs(dy)<1){
									dy=abs(dy)/dy;
								}
							}
							d_mo.style.top=parseInt(mXY[1]+(mXY[1]!=y?dy:0))-offXY[1]+"px";
						}
					}
					if(x!=mXY[0]||y!=mXY[1]){
						with(d_dm[i]){
							var d_co=_dmoi(m[0].id);
							_dmfa(d_co);
							if(dmObjectsCheck){
								_dmzz(m[0]);
								_dmi(m[0],dengine._dmos(d_co));
							}
						}
					}
				}
			}
		}
	}
}

function _dmyq(x,y,r){
	return x>=r.x1&&x<=r.x2&&y>=r.y1&&y<=r.y2?1:0;
}

function _dmft(x,y1,y2,r){
	return x>=r.x1&&x<=r.x2&&y1<=r.y1&&y2>=r.y2?1:0;
}

function _dmhp(x1,x2,y,r){
	return y>=r.y1&&y<=r.y2&&x1<=r.x1&&x2>=r.x2?1:0;
}

function _dmig(r,tr){
	if(_dmyq(r.x1,r.y1,tr)+_dmyq(r.x2,r.y2,tr)||_dmyq(r.x1,r.y2,tr)+_dmyq(r.x2,r.y1,tr)){
		return 1;
	}
	return 0;
}

function _dmyw(r,tr){
	if(_dmig(r,tr)||_dmig(tr,r)){
		return 1;
	}
	if(_dmft(r.x1,r.y1,r.y2,tr)||_dmft(r.x2,r.y1,r.y2,tr)||_dmhp(r.y1,r.x1,r.x2,tr)||_dmhp(r.y2,r.x1,r.x2,tr)){
		return 1;
	}
	return 0;
}

function _dmrc(r,d_sz){
	with(r){
		x1=d_sz[0];
		x2=d_sz[0]+d_sz[2];
		y1=d_sz[1];
		y2=d_sz[1]+d_sz[3];
	}
}

function _dmih(d_ce,d_cc,d_ot){
	if(d_oo&d_v<6){
		return;
	}
	var d_ddm=d_dm[d_ce.d_mi];
	var frame=!d_ddm.d_dcf||d_t==3?window:parent.frames[d_ddm.d_is];
	var d_os=frame.document.getElementsByTagName(d_ot);
	if(!d_os){
		return;
	}
	var d_oz,o;
	var d_cr={x1:0,y1:0,x2:0,y2:0};
	var oR={x1:0,y1:0,x2:0,y2:0};
	_dmrc(d_cr,d_cc);
	for(var i=0;i<d_os.length;i++){
		o=d_os[i];
		d_oz=dengine._dmos(o);
		_dmrc(oR,d_oz);
		if(o.style&&!o.dm){
			if(o.style.visibility!="hidden"&&_dmyw(d_cr,oR)){
				var tmp=o;
				while(tmp&&(!tmp.id||!_dmvi(tmp.id))){
					tmp=tmp.parentNode;
				}
				if(!tmp){
					o.style.visibility="hidden";
					d_ce.d_dho[d_ce.d_dho.length]=o;
				}
			}
		}
	}
}

function _dmzz(d_ce){
	with(d_ce){
		for(var j=0;j<d_dho.length;j++){
			d_dho[j].style.visibility="visible";
		}
		d_dho=[];
	}
}

function _dmi(d_ce,d_cc){
	var d_dhe=d_e&&(d_v<6||d_qu);
	if(typeof dm_ext_ruleIFrameHide=="function"){
		if(dm_ext_ruleIFrameHide()){
			_dmih(d_ce,d_cc,"IFRAME");
		}
	}else if(d_dhe||d_oo&&d_v<9||d_n&&d_v<7){
		_dmih(d_ce,d_cc,"IFRAME");
	}
	
	if(typeof dm_ext_ruleObjectHide=="function"){
		if(dm_ext_ruleObjectHide()){
			_dmih(d_ce,d_cc,"OBJECT");
			_dmih(d_ce,d_cc,"EMBED");
		}
	}else if(d_dhe||d_n&&d_v>=7||d_z||d_oo){
		_dmih(d_ce,d_cc,"OBJECT");
		_dmih(d_ce,d_cc,"EMBED");
	}
	if(typeof dm_ext_ruleSelectHide=="function"){
		if(dm_ext_ruleSelectHide()){
			_dmih(d_ce,d_cc,"SELECT");
		}
	}else if(d_dhe||d_oo&&d_v<7){
		_dmih(d_ce,d_cc,"SELECT");
	}if(typeof dm_ext_ruleInputHide=="function"){
		if(dm_ext_ruleInputHide()){
			_dmih(d_ce,d_cc,"TEXTAREA");
			_dmih(d_ce,d_cc,"INPUT");
		}
	}else if(d_oo&&d_v<7){
		_dmih(d_ce,d_cc,"TEXTAREA");
		_dmih(d_ce,d_cc,"INPUT");
	}
	if(typeof dm_ext_ruleAppletHide=="function"){
		if(dm_ext_ruleAppletHide()){
			_dmih(d_ce,d_cc,"APPLET");
		}
	}else if(d_dhe||d_oo){
		_dmih(d_ce,d_cc,"APPLET");
	}
}