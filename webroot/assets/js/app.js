window.onunload = function() {};

var app = {};
var _app;
var _spMenu;

/* -------------------------------------------------------------------------------------

 Config

 ------------------------------------------------------------------------------------- */
app.Conf = {
//	IS_DEBUG: true,
	IS_DEBUG: false,
	IS_DETAIL:false,
	NEWS_RPP: 20,
	API: {
		"calender": {
			"path_pro": "/api/calender/",
			"path": "/-dammy-api/calender.json",
			"method":"get"
		},
		"news": {
			"path_pro": "/api/news/",
			//"path_pro": "/-dammy-api/news.json",
			"path": "/-dammy-api/news.json",
			"method":"get"
		},
		"related": {
			"path_pro": "/api/related/",
//			"path": "/-dammy-api/related.json",
			"path": "/-dammy-api/related-profile.json",
			"method":"get"
		},
		"profile": {
			"path_pro": "/api/profile/",
			"path": "/-dammy-api/profile.json",
			"method":"get"
		},
		"fanclub": {
			"path_pro": "/api/fanclub/",
			"path": "/-dammy-api/fanclub.json",
			"method":"get"
		},
		"service": {
			"path_pro": "/api/service/",
			"path": "/-dammy-api/service.json",
			"method":"get"
		},
		"onair": {
			"path_pro": "/api/onair/",
//			"path_pro": "/-dammy-api/onair.json",
			"path": "/-dammy-api/onair.json",
//			"path": "/-dammy-api/onair-guest.json",
			"method":"get"
		},
		"clip": {
			"path_pro": "/api/search/",
			"path": "/-dammy-api/search.json",
			"method":"get"
		},
		"keyword": {
			"path_pro": "/api/keywords/",
			"path": "/-dammy-api/keyword.json",
			"method":"get"
		},
		"search": {
			"path_pro": "/api/search/",
			"path": "/-dammy-api/search.json",
			"method":"get"
		}
	}
}


/* -------------------------------------------------------------------------------------
 App main
 ------------------------------------------------------------------------------------- */
app.Main = okb.EventDispatcher.extend({

	EV_READY:"evReady",

	__construct:function(){
		this.__super.__construct.apply(this, arguments)
		var me = this;
	},

	/*  dom ready
	 --------------------------------------------------*/
	domReady:function(){
		var me = this;

		//RPPの変更
		if(_ctrl.clientW > 1397 - 20) {
			app.Conf.NEWS_RPP = 80;
		} else if(_ctrl.clientW > 1200 - 20) {
			app.Conf.NEWS_RPP = 50;
		} else if(_ctrl.clientW > 980) {
			app.Conf.NEWS_RPP = 40;
		}

		//
		me.trigger(me.EV_READY);///////
	},

});

/* -------------------------------------------------------------------------------------
	util
 ------------------------------------------------------------------------------------- */
app.loadAPI = function(apiKey, vals, callback, errorCallback){
	var api = app.Conf.API[apiKey];
	trace("------------------------");
	trace("*api: "+apiKey);
	trace(vals);
	trace(" ");
	return $.ajax({
		type: api["method"],
		dataType: api["dataType"] || "json",
		cache: true,
		url: api[(app.Conf.IS_DEBUG? "path": "path_pro")],
		data: vals,
		success:function(data) {
			if(!data) return;
			if (callback) callback(data);
		},
		error:function(XMLHttpRequest, textStatus, errorThrown) {
			//error
			trace("api error ---------------")
			trace(XMLHttpRequest)
			trace(textStatus)
			trace(errorThrown)
			trace(" ");
			if (errorCallback) errorCallback();
		}
	});
}

/* -------------------------------------------------------------------------------------
 SearchBox
 ------------------------------------------------------------------------------------- */
app.SearchBox = okb.EventDispatcher.extend({

	__construct:function($me){
		this.__super.__construct.apply(this, arguments)
		var me = this;
		me.$ = $me;

		me.$form = me.$.find(".searchBox form");
		me.$input = me.$.find(".searchBox .text");
		me.$btEnter = me.$.find(".searchBox a");

		me.$searchBaloon = me.$.find(".searchBaloon");
		me.$blockIdx = {
			"news": me.$searchBaloon.find(".blockNews"),
			"profile": me.$searchBaloon.find(".blockProfile"),
			"beamie": me.$searchBaloon.find(".blockBeamie")
		}

		me.$input
			.on("focus", function(e){
				me.val = null;
				me._searchKeyword();
				setTimeout(function(){
					me._bindKeyUp(true)
				}, 200);
			})
			.on("blur", function(e){
				me._bindKeyUp(false);
				setTimeout(function(){
					me._showBaloon(false);
				}, 100);
			})

		me.$form.on("submit", function(e){
			e.preventDefault();
			me.$input.blur();
			me._doSearch();
			return false;
		})

		me.$btEnter.on("click", function(e){
			e.preventDefault();
			me._doSearch();
		})


		//ハッシュの変更で閉じる
		_ctrl.$window.hashchange(function(e){
			me._showBaloon(false);
			me.$input.blur();
		})

	},

	_bindKeyUp:function(isBind){
		var me = this;
		if(isBind) {

			var KEY_UP = 38;
			var KEY_DOWN = 40;
			var KEY_ENTER = 13;
			me.$input.on("keyup", function(e){
				me._searchKeyword();
			})
			me.$input.on("click", function(e){
				me._searchKeyword();
			})

		} else {
			me.$input.off("keyup click")
		}
	},

	_searchKeyword:function() {
		var me = this;
		return;//一時的にサジェストをOFF

		var val = me.$input.val();
		if(val==me.val) return;
		me.val = val;

		if(!val) {
			me._showBaloon(false);
			return;
		}

		if(me.currentXHR) me.currentXHR.abort();
		me.currentXHR = app.loadAPI("keyword", {"text":val}, function(data){
			data = data["data"];
			var hash = data["hash"];
			var hitCnt = 0;
			for(var key in me.$blockIdx){
				var $block = me.$blockIdx[key];
				var list = hash[key] || [];
				var i, len = list.length;
				var html = '';
				for (i = 0; i < len; i++) {
					hitCnt++;
					var obj = list[i];
					var link = '/#/'+key+'/entry/'+obj["id"];
					var link_target = '_self';
					if(obj["direct_url"]) {
						link = obj["direct_url"];
						//link_target = '_blank';
					}
					html += '<li><a href="'+link+'" target="'+link_target+'">'+obj["title"]+'</a></li>'
				}
				$block.find("ul").html(html);
				if(len>0) $block.removeClass("hide");
				else $block.addClass("hide");
			}
			me._showBaloon( hitCnt>0 );
		});
	},

	_showBaloon:function(isShow){
		var me = this;
		if(me.isShow == isShow) return;
		me.isShow = isShow;

		if(isShow) {
			me.$searchBaloon.addClass("show");
		} else {
			me.$searchBaloon.removeClass("show");
			if(me.currentXHR) me.currentXHR.abort();
		}
	},

	_doSearch:function(){
		var me = this;
		var val = me.$input.val();
		location.href = "/#/search/" + encodeURIComponent(val);
	}

});

/* -------------------------------------------------------------------------------------
 SPMenu
 ------------------------------------------------------------------------------------- */
app.SPMenu = okb.EventDispatcher.extend({

	EV_OPEN:"evOpen",

	__construct:function($me){
		this.__super.__construct.apply(this, arguments)
		var me = this;
		me.$ = $me;
		me.$spKnobspKnob = $(".spKnob");
		me.$hiddenSpMenuClose = $(".hiddenSpMenuClose");

		me.$spKnobspKnob.on("touchend click", function(e){
			e.preventDefault();
			e.stopPropagation();
			me._switchOpen(true);
		})
		me.$hiddenSpMenuClose
			.on("click", function(e){
				e.preventDefault();
				e.stopPropagation();
				me._switchOpen(false);
			})
			.on("touchmove", function(e){
				e.preventDefault();
				e.stopPropagation();
			})

		//ハッシュの変更で閉じる
		_ctrl.$window.hashchange(function(e){
			me._switchOpen(false, 700);
		})

		//androidでoverflowのスクロールが効かないのに対応
		if(_ctrl.android) {
			me.$.overflowScroll();
		}
	},

	_switchOpen:function(isOpen, delay){
		var me = this;
		if(me.delayID) clearTimeout(me.delayID);
		me.delayID = setTimeout(function(){
			if(isOpen) _ctrl.$body.addClass("showMenu");
			else _ctrl.$body.removeClass("showMenu");
			if(isOpen) me.trigger(me.EV_OPEN);
		}, delay||0);
	}

});


/* -------------------------------------------------------------------------------------
 init
 ------------------------------------------------------------------------------------- */
_app = new app.Main();
$(function() {

	//SPメニュー
	_spMenu = new app.SPMenu( $(".spMenu") );

	_app.domReady();

	//検索ボックス
	new app.SearchBox( $(".searchArea") );

	//サイトフッター
	$(".siteFooter .bnrs").each(function(){
		var $bnrs = $(this);
		$bnrs.find("li").each(function(index){
			if(index==0) return;
			if(index%5==0) $(this).before('<li class="clear clear5"></li>');
			if(index%4==0) $(this).before('<li class="clear clear4"></li>');
			if(index%3==0) $(this).before('<li class="clear clear3"></li>');
			if(index%2==0) $(this).before('<li class="clear clear2"></li>');
		})
	})

	//btHover
	$(".btHover").each(function(index){
		var $btn = $(this);
		var $img = $btn.find("img");

		var w = parseInt( $img.attr("width"), 10 );
		var h = parseInt( $img.attr("height"), 10 );
		var imgSrc = $img.attr("src");
		var imgSrcOv = imgSrc.substr(0, imgSrc.length-4) + "-ov" + imgSrc.substr(imgSrc.length-4);
		if( $img.attr("data-src-ov") ) imgSrcOv = $img.attr("data-src-ov");
		$btn.css({
			"width": w,
			"height": h,
			"background-image": "url(" + imgSrcOv + ")",
			"background-repeat": "no-repeat",
			"background-position": "left top"
		})
	})

	//show!
	setTimeout(function(){
		$(".mainArea, .todayArea, .sideArea").addClass("show");
	}, 2);
});