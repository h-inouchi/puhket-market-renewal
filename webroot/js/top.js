app.top = {};
var _hero;
var _splash;
var _todayOnAir;



/* -------------------------------------------------------------------------------------

 top main

 ------------------------------------------------------------------------------------- */
app.top.Main = okb.EventDispatcher.extend({

	EV_FB_INIT:"evFbInit",

	__construct:function(){
		this.__super.__construct.apply(this, arguments)
		var me = this;

		//Hero（メインビジュアル）
		_hero = new app.top.Hero();

		//Splash
		if($(".splashArea").length>0 && app.top) {
			_splash = new app.top.Splash();
			if(!_splash.activeSplash) _splash = null;
		}
		$(".heroArea").on("mouseup", "a", function(e){
			if(_splash) {
				_splash.close(900, false);
				_splash = null;
			}
		})

		//本日の出演情報
		_todayOnAir = new app.TodayOnAir( $(".todayArea") );

		//カテゴリナビ
		new app.SideCNav( $(".sideArea .side-cnav"), true );
		new app.SideCNav( $(".spMenu .side-cnav"), false );

		//ニュース部分
		_news = new app.top.News();
		_news.init();

		//ニュースのスクロールに合わせてSplashを閉じる
		_news.bind(_news.EV_SCROLL, function(){
			if(_splash) {
				_splash.close(500, false);
				_splash = null;
			}
		})

		//ロゴクリックでmain/today表示
		$(".siteLogo a").on("click", function(e){
			_hero.switchShow(true);
			_todayOnAir.switchShow(true);
		})

	}

});





/* -------------------------------------------------------------------------------------

 Hero（メインビジュアル）　＊newsに操作される

 ------------------------------------------------------------------------------------- */
app.top.Hero = okb.EventDispatcher.extend({

	__construct:function(){
		this.__super.__construct.apply(this, arguments);
		var me = this;
		me.$crop = $(".heroCrop");
		me.$ = $(".heroArea");

		me.isShow = false;

		me._initCarrousel();
	},

	getHeight:function(){
		var me = this;
		return me.isShow? me.$.outerHeight(): 0;
	},

	getCropHeight:function(){
		var me = this;
		return me.$crop.outerHeight();
	},

	switchShow:function(isShow, isDirect){
		var me = this;
		if(isShow==me.isShow) return;
		me.isShow = isShow;
		var th = me.getHeight();
		var time = isDirect? 0: 500;
		me.$crop.stop().animate({"height":th}, time, "easeInOutQuart", function(){
			if(isShow) me.$crop.css("height", "auto");
		})

		if(isShow) me._startAuto();
		else me._stopAuto();
	},

	_initCarrousel:function(){
		var me = this;

		//カルーセル
		me.carrouselImage = new okb.ui.Carrousel( $(".imageWrap"), { fullW:true, heroImage:true } );
		me.carrouselThum = new okb.ui.Carrousel( $(".thumWrap"), { fullW:true } );

		me.carrouselThum.bind(me.carrouselThum.EV_CHANGE_ACTIVE, function(e, btnNum){
			me.carrouselImage.switchPageByOriginalNum(btnNum);
			me._startAuto();
		})
		me.carrouselImage.bind(me.carrouselThum.EV_CHANGE_ACTIVE, function(e, btnNum){
			me.carrouselThum.switchPageByOriginalNum(btnNum);
			me._startAuto();
		})

		//メイン画像後読み
		$(".imageWrap ul li img").each(function(index){
			var $img = $(this);
			if($img.attr("data-src")) $img.attr("src", $img.attr("data-src"));
		})

		//image loading
		setTimeout(function(){

			var $liImage = $(".imageWrap ul li");
			var $liThum = $(".thumWrap ul li");
			$liImage.add($liThum).each(function(index){
				var $li = $(this);
				var num = $liImage.index($li);
				if(num<0) num = $liThum.index($li);
				var loaded = function(){
					$li.addClass("loaded");
				}
				$li.imagesLoaded({
					callback: function($images, $proper, $broken){
						setTimeout(function(){
							loaded();
						}, 1 + num*50);
					},
					progress: function (isBroken, $images, $proper, $broken) {
					}
				});
				setTimeout(function(){
					loaded();
				}, 7000);
			})

		}, 300);
	},

	_startAuto:function(){
		var me = this;
		if(me.autoID) clearInterval(me.autoID);
		me.autoID = setInterval(function(){
			if(me.carrouselThum.isMoved || me.carrouselImage.isMoved) return;
			me.carrouselThum.goNextActiveBtn(true);
		}, 6000);
	},

	_stopAuto:function(){
		var me = this;
		if(me.autoID) clearInterval(me.autoID);
	}

});



/* -------------------------------------------------------------------------------------

 splash

 ------------------------------------------------------------------------------------- */
app.top.Splash = okb.EventDispatcher.extend({

	__construct:function(){
		this.__super.__construct.apply(this, arguments);
		var me = this;

		var $areaArr = [];
		$(".splashArea").each(function(index){
			var $area = $(this);
			var cookie_name = "top-splash-" + $area.attr("data-entry_id");
			if(Number($.cookie(cookie_name))==1) {
				$area.remove();
				return;
			}
			$areaArr.push($area);
		})

		$areaArr.sort(function(a,b){ return Math.random()<0.5? -1: 1; })

		var i, len = $areaArr.length;
		for (i = 1; i < len; i++) {
			$areaArr[i].remove();
		}

		if($areaArr.length==0) return;
		me.activeSplash = true;

		me.$ = $areaArr[0];
		me.$inr = me.$.find(".inr");

		me.entry_id = me.$.attr("data-entry_id");
		me.cookie_name = "top-splash-" + me.entry_id;

			//cookieで一回しか開かない
		$.cookie(me.cookie_name, 1);

		//
		me.isOpen = false;

		//画像のロード待ち
		var isImageLoaded = false;
		function imageLoaded(){
			if(isImageLoaded) return;
			isImageLoaded = true;
			me._init();
		}
		me.$.imagesLoaded({
			callback: function($images, $proper, $broken){
				setTimeout(function(){
					imageLoaded();
				}, 1);
			},
			progress: function (isBroken, $images, $proper, $broken) {
			}
		});
		if(me.delayID) clearTimeout(me.delayID);
		me.delayID = setTimeout(function(){
			imageLoaded();
		}, 7000);

		//close
		me.$.find(".pic a").on("click", function(e){
			e.stopPropagation();
			me.close(900, true);
		})
		me.$.on("click", function(e){
			e.preventDefault();
			me.close(900, true);
		})
	},

	_init:function(){
		var me = this;
		me.h = me.$inr.outerHeight();
		me.h2 = Math.round(me.h*0.5);
		var time = 1500;

		me.isOpen = true;

		me.$.animate({"height": me.h}, time, "easeInOutQuart", function(){
			me.$.css("height", "").addClass("show");
		})

		me.$inr.css("margin-top", -me.h2);
		me.$inr.animate({"margin-top": 0}, time, "easeInOutQuart" )

		var ts = me.$.offset().top + me.h2 - _ctrl.clientH*0.5;
		_ctrl.$html_body.stop().animate({"scrollTop":ts}, time, "easeInOutQuart")
	},

	getHeight:function(){
		var me = this;
		return me.h;
	},

	close:function(time, withScroll){
		var me = this;
		if(!me.isOpen) return;
		me.isOpen = false;

		me.$.animate({"height": 0}, time, "easeInOutQuart", function(){
			me.$.remove();
		})

		me.$inr.animate({"margin-top": -me.h2}, time, "easeInOutQuart" );

		if(withScroll) {
			_ctrl.$html_body.stop().animate({"scrollTop":_ctrl.scrollTop-me.h2}, time, "easeInOutQuart")
		}

	}

});







/* -------------------------------------------------------------------------------------

 init

 ------------------------------------------------------------------------------------- */
_app.bind(_app.EV_READY, function(e){
	new app.top.Main();
});