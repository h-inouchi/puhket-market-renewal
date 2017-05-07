app.news = {};
var _news;


/* -------------------------------------------------------------------------------------

 top news

 ------------------------------------------------------------------------------------- */
app.top.News = okb.EventDispatcher.extend({

	EV_SCROLL:"evScroll",

	__construct:function(){
		this.__super.__construct.apply(this, arguments)
		var me = this;
	},

	init:function(){
		var me = this;

		//animation
		_ctrl.initTween();

		//
		me.$siteHeader = $(".siteHeader");
		me.$splashArea = $(".splashArea");
		me.$mainContent = $(".mainContent");
		me.$mainArea = $(".mainArea");

		//
		me.cardManger = new app.top.CardManager( $(".cardArea") );
		me.onAirManager = new app.top.OnAirManager( $(".onairArea") );

		//ハッシュの変更をひろう
		_ctrl.$window.hashchange(function(e){
			me._hashChanged();
		})
		me._hashChanged(true);
	},

	_hashChanged:function(isFirst){
		var me = this;

		var hash = location.hash || "#";
		if(app.Conf.IS_DETAIL) hash = "#" + location.pathname;
		if(hash.indexOf("#/")<0) hash = "#/";
		var rawHash = hash;
		if(hash=="#/") hash = "#/news";
		var hash1 = hash.split("/")[1];
		me.rawHash = rawHash;
		me.hash = hash;
		me.isFirstHashChanged = isFirst;

		//hero
		if(rawHash=="#/") _hero.switchShow(true, isFirst);
		else _hero.switchShow(false, isFirst);

		//本日の出演情報
		if(rawHash=="#/") _todayOnAir.switchShow(true, isFirst);
		else _todayOnAir.switchShow(false, isFirst);

		//show / hide
		var manager = (hash1=="onair")? me.onAirManager: me.cardManger;
		if(manager!=me.manager) {
			if(me.manager) me.manager.switchShow(false);
			me.manager = manager;
			if(me.manager) me.manager.switchShow(true);
		}

		//hash changed
		if(me.manager) {
			var hashArr = hash.split("/");
			hashArr.shift();
			me.manager.hashChanged(isFirst, hashArr);
		}

		//最初のscroll頭出し
		if(isFirst) {
			if(rawHash!="#/" && !_splash) {
				me.scrollToContent(1);
				$(window).load(function(e){
					me.scrollToContent(1);
				})
			}
		}


		/* GA */
		_news.trackPage();

	},

	scrollToContent:function(time){
		var me = this;
		time = time || 500;
		var heroChangeH = _hero.getHeight() - _hero.getCropHeight();
		var ty = me.$mainContent.offset().top - me.$siteHeader.height() - (me.$splashArea.height()||0) + heroChangeH;
		if(me.rawHash=="#/") ty = 0;
		_ctrl.$html_body.stop().animate({"scrollTop": ty}, time, "easeInOutQuart");
		if(!me.isFirstHashChanged) me.trigger(me.EV_SCROLL);//////
	},


	/*  見えてるカードを判別
	 --------------------------------------------------*/
	selectVisibleCard:function($list){
		var me = this;
		var visibleYTop = 0;
		var visibleYBottom = _ctrl.clientH;
		$list.find(".card").removeClass("inArea outArea").each(function(){
			var $card = $(this);
			var yTop = $card.offset().top - _ctrl.scrollTop;
			var yBottm = yTop + $card.outerHeight();
			if(yTop<visibleYBottom && yBottm>visibleYTop) $card.addClass("inArea");
			else $card.addClass("outArea");
		})
	},

	/*  カードをアニメーション表示
	 --------------------------------------------------*/
	showCardWithAnime:function($list){
		var me = this;
		var baseX = me.$mainContent.offset().left;
		var baseY = _ctrl.scrollTop;
		$list.find(".card.hide.summary.inArea").each(function(index){
			var $card = $(this);
			var delay = ($card.offset().left - baseX)/197 * 150 + ($card.offset().top - baseY)/300 * 200;
			_ctrl.tween( $card, {rotationY:-90, perspective:500}, {rotationY:0, perspective:500}, 360, delay, TWEEN.Easing.Quadratic.InOut,
				function(){
					$card.removeClass("hide");
				}, function(){

				} );
		})
		$list.find(".card.summary.outArea").removeClass("hide");
	},

	/*  ローディング表示
	 --------------------------------------------------*/
	switchLoading:function(isShow, delay){
		var me = this;
		if(isShow==me.isLoadingShow) return;
		me.isLoadingShow = isShow;
		me.loadingID = setTimeout(function(){
			if(isShow) {
				me.$mainContent.removeClass("loaded");
			} else {
				me.$mainContent.addClass("loaded");
			}
		}, delay||0);
	},

	/* GA */
	trackPage:function(addPage, forceEntry, forceCat){
		var me = this;
		var hash = location.hash || "";
		if(hash.indexOf("#/")<0) hash = "#/";
		var page = "/" + hash.split("#/").slice(1).join("/");
		if(addPage) page += addPage;
		if(forceEntry) page = "/" + forceCat + "/entry/"+forceEntry;
		page += "/";
		page = page.split("//").join(("/"));
		GA.trackPage(page);
	}

});


/* -------------------------------------------------------------------------------------

 card

 ------------------------------------------------------------------------------------- */
app.top.CardManager = okb.EventDispatcher.extend({

	__construct:function($me){
		this.__super.__construct.apply(this, arguments)
		var me = this;
		me.$ = $me;

		//get cards
		me.$list = $(".cardList");
		me.$cardRuler = me.$.find(".cardRuler");
		me.$tpl_card_contact = me.$list.find(".card-contact").remove();
		me.$tpl_card_fanletter = me.$list.find(".card-fanletter").remove();
		me.$tpl_card_news_summary = me.$list.find(".card-news.summary").remove();
		me.$tpl_card_news_detail = me.$list.find(".card-news.detail").remove();
		me.$tpl_card_profile_summary_normal = me.$list.find(".card-profile.card-normal").remove();
		me.$tpl_card_profile_detail = me.$list.find(".card-profile.detail").remove();
		me.$tpl_card_fanclub = me.$list.find(".card-fanclub").remove();
		me.$tpl_card_service = me.$list.find(".card-service").remove();

		me.$tpl_h_idx = {}
		me.$list.find(".h-content").each(function(index){
			me.$tpl_h_idx[ $(this).attr("data-name") ] = $(this).remove();
		})

		//カードの幅取得
		me.rulerW = me.$cardRuler.width();

		//btMore
		me.$btMore = $(".btMore");
		me.$btMore.find("a").on("click", function(e){
			e.preventDefault();
			me.$btMore.addClass("isLoading");
			me._waitListLoad( me.hash2 );
		})

		//noResult
		me.$noResult = $(".noResult");

		//btns
		me.$list.on("click", "a", function(e){
			var $btn = $(this);

			//close
			if($btn.hasClass("btClose")){
				e.preventDefault();
				me._close();
			}

			//お問い合わせGA
			if($btn.hasClass("btInquiry")){
				_news.trackPage("/contact");
			}

			//ファンレターGA
			if($btn.hasClass("btFanletter")){
				_news.trackPage("/fanletter");
			}

			//外部リンクGA
			if($btn.hasClass("btCardDirect")){
				var id = $btn.attr("data-id");
				var cat = $btn.attr("data-cat");
				_news.trackPage(null, id, cat);
			}

			//MY CLIP
			if($btn.hasClass("btClip")){
				e.preventDefault();

				/* GA (なぜかこの前に1行でも処理が追加されるとGAが送信されなくなる・・) */
				GA.trackEvent('clip', ($btn.hasClass("before")? 'add': 'remove'), $btn.parent().attr("data-id") );

				var id = $btn.parent().attr("data-id");
				if($btn.hasClass("before")) me._clip(id, true);
				else if($btn.hasClass("after")) me._clip(id, false);
			}

			//PRINT
			if($btn.hasClass("btPrint")){
				e.preventDefault();

				/* GA */
				GA.trackEvent('print', 'click', $btn.attr("data-id") );

				window.print();
			}
		})

		//resize
		me._resized = function(){
			//masonry
			if(me.resizeID) clearTimeout(me.resizeID);
			me.resizeID = setTimeout(function(){
				me._layout();
			}, 50);
		}
		_ctrl.$window.on("resize", function(){
			me._resized();
		})
		me._resized();

	},

	switchShow:function(isShow){
		var me = this;
		if(isShow) me.$.addClass("show");
		else me.$.removeClass("show");
	},

	hashChanged:function(isFirst, hashArr){
		var me = this;
		me.isFirstHashChanged = isFirst;
		me.hashArr = hashArr;
		me.blog_name = hashArr[0];
		me.hash1 = hashArr[1];
		me.hash2 = hashArr[2];
		if(me.hash1!="entry") {
			//リスト
			me.rememberListHash = hashArr.join("/");
			me.current_entry_id = null;
			if(!isFirst) {
				_news.scrollToContent(500);
			}
		} else {
			//詳細
			me.current_entry_id = hashArr[2];
		}

		//profile - arr
		if(me.blog_name=="profile" && !me.hash1) me.$.addClass("profile-all");
		else me.$.removeClass("profile-all");

		//画像同じもの2枚以上出さないように
		me.displayImageIdx = {};

		//ページを初期化
		me.page = 0;

		//API cancel
		if(me.currentXHR) me.currentXHR.abort();

		//next step
		if(isFirst) me._waitListLoad(me.current_entry_id);
		else me._hideList(me.current_entry_id);
	},

	_close:function(){
		var me = this;
		location.href = "#/" + (me.rememberListHash || "");
		_news.scrollToContent();
	},

	_hideList:function(entry_id){
		var me = this;

		//show loader
		if(!entry_id) {
			_news.switchLoading(true);
		}

		//見えてるカードを判別
		_news.selectVisibleCard(me.$list);

		me.$entryLoader = null;
		me.$list.find(".card").each(function(){
			var $card = $(this);
			//クリックされたカードをローディング表示
			if($card.attr("data-id")==entry_id && me.$entryLoader==null) {
				me.$entryLoader = $card;
				me.$entryLoader.addClass("isLoading");
				return;
			}
			//他のカードはさっと消す
			$card.remove();
			$card = null;
		})

		//見出しを削除
		me.$list.find(".h-content").remove();

		//noResultを非表示
		me.$noResult.removeClass("show");

		//動画キャンセル
		if(me.movieID) clearTimeout(me.movieID);

		//next step
		var waitTime = entry_id? 0: 500;
		if(me.delayID) clearTimeout(me.delayID);
		me.delayID = setTimeout(function(){
			me._waitListLoad(entry_id);
		}, waitTime);

	},

	_waitListLoad:function(entry_id){
		var me = this;

		me.page++;

		var api = me.blog_name;
		if(entry_id) api = "related";
		me.currentAPI = api;

		var vals = {};
		vals["page"] = me.page;
		vals["rpp"] = app.Conf.NEWS_RPP;
		if(entry_id) {
			vals["id"] = entry_id;
		} else {
			if(api=="news") {
				if(me.hash1 && me.hash1.indexOf("20")==0) vals["archive"] = me.hash1;
				else vals["category"] = me.hash1;
			}
			else if(api=="profile") {
				if(me.hash1) {
					if(me.hash1=="sort") vals["sort"] = me.hash2;
					else vals["category"] = me.hash1;
				}
			}
			else if(api=="fanclub") {
				if(me.hash1) vals["category"] = me.hash1;
			}
			else if(api=="service") {
				if(me.hash1) vals["category"] = me.hash1;
			}
			else if(api=="clip") {
				var idArr = me._clip();
				vals["ids"] = idArr;
			}
			else if(api=="search") {
				vals["keyword"] = decodeURIComponent(me.hash1);
			}
		}

		//wait API load
		if(!app.Conf.IS_DETAIL) {

			me.currentXHR = app.loadAPI(api, vals, function(data){
				data = data["data"] || {};

				//MOREボタンを表示するかどうか
				me.isBtMoreShow = false;
				if(data["list"] && data["list"].length>=app.Conf.NEWS_RPP) me.isBtMoreShow = true;

				//next step
				if(entry_id && me.page<=1) {
					me._waitDetailLoad(data, entry_id);
				} else {
					me._showList(data);
				}
			})

		} else {
			me._waitDetailLoad({list:[app.ENTRY_DATA]}, entry_id);
		}
	},

	_waitDetailLoad:function(data, entry_id){
		var me = this;

		//dataの中から合致するentry_idのものを見つける
		var list = data["list"];
		var item = list[0];

		/* GA title */
		me.gaTitle = item["title"];

		//記事詳細の作成
		var $tpl = (item["blog"]=="news")? me.$tpl_card_news_detail: me.$tpl_card_profile_detail;
		var $detail = $tpl.clone().appendTo(me.$list);
		me.current_tags = item["tag"] || [];
		me._initCard($detail, item, true);

		//画像のロード待ち
		var isImageLoaded = false;
		function imageLoaded(){
			if(isImageLoaded) return;
			isImageLoaded = true;
			if(me.current_entry_id==entry_id) {
				if(me.$entryLoader) {
					_news.scrollToContent(time);
					var time = 500;
					me.$entryLoader.addClass("loaded").stop().animate({
						"left": 0,
						"top": 0,
						"width": $detail.outerWidth(),
						"height": $detail.outerHeight()
					}, time, "easeInOutQuart", function(){
						me.$entryLoader.remove();
						$detail.removeClass("hide");
						me._showList(data);
					});
				} else {
					if(!me.isFirstHashChanged) _news.scrollToContent(time);
					$detail.removeClass("hide");
					me._showList(data);
				}

				//social
				setTimeout(function(){
					if(me.current_entry_id!=entry_id) return;
					me._initSocials($detail, item);
				}, 1000)
			}
		}

		//動画のあるなしでロード待ち分岐
		if(item["youtube_id"]) {
			$detail.addClass("hasMovie");
			imageLoaded();
			if(me.movieID) clearTimeout(me.movieID);
			me.movieID = setTimeout(function(){
				var w = $detail.hasClass("portrait")? 776: 579;
				$detail.find(".movie").html( '<iframe width="'+w+'" height="326" src="//www.youtube.com/embed/'+item["youtube_id"]+'?rel=0" frameborder="0" allowfullscreen></iframe>');
				$(window).trigger("resize");
			}, 900);
		}
		else {
			$detail.find(".movie").remove();

			$detail.imagesLoaded({
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
		}
	},

	_showList:function(data){
		var me = this;

		//0件のときnoResultを表示
		if(!data["hash"] && !data["list"]) data["list"] = [];
		if(data["list"]) {
			if(data["list"].length==0 && me.hash1!="entry" ) {
				me.$noResult.addClass("show");
				if(!_ctrl.ie678) {
					me.$noResult.stop().css({"opacity":0}).animate({"opacity":1}, 900, "easeInOutQuad")
				}
			}
		}

		//hide loader
		_news.switchLoading(false);

		//記事詳細の場合のみ
		if(me.hash1=="entry") {
			if(me.page<=1) {
				if(me.current_tags.indexOf("第１４回全日本国民的美少女コンテスト")<0) {
					//お問い合わせカードの追加
					me.$tpl_card_contact.clone().appendTo(me.$list);
				}
				if(me.blog_name=="profile") {
					me.$tpl_card_fanletter.clone().appendTo(me.$list);
				}
			}
		} else {

			/* GA title */
			me.gaTitle = null;
			if(me.hash1) me.gaTitle = me._translateCatToJP(me.hash1);
		}

		//カードの生成
		var seqCnt = 0;
		var preCat = null;
		function makeCardByList(list){
			if(me.hash1=="entry") list.shift();
			var i, len = list.length;
			for (i = 0; i < len; i++) {
				//FANCLUB見出し
				var cat = (list[i]["category"]||[])[0];
				if(me.blog_name=="fanclub" && !me.hash1 && me.page==1) {
					if(seqCnt==0) me.$tpl_h_idx["fanclub-special"].clone().appendTo(me.$list);
					if(preCat=="page" && cat!="page") me.$tpl_h_idx["fanclub-others"].clone().appendTo(me.$list);
				}
				preCat = cat;
				//
				seqCnt++;
				var delayTime = seqCnt>50? 500: 0;
				me._makeCard(list[i], delayTime);
			}
		}
		if(data["list"]) {
			// NEWS / FANCLUB
			makeCardByList(data["list"]);
		}
		else if(data["hash"]) {
			//PROFILE / SERVICE
			var obj = data["hash"];
			for(var key in obj) {
				if(obj[key] && obj[key].length>0) {
					//見出し
					if(me.$tpl_h_idx[key] && !me.hash1) me.$tpl_h_idx[key].clone().appendTo(me.$list);
					//カード
					makeCardByList(obj[key]);
				}
			}
		}

		//masonry
		me._layout();
		setTimeout(function(){
			me._layout();
		}, 0)
		setTimeout(function(){
			me._layout();
		}, 500);

		//btMore
		if(me.isBtMoreShow) me.$btMore.removeClass("isLoading").addClass("show");
		else me.$btMore.removeClass("show");

		//カード表示
		var showDelay = (me.hash1=="entry")? 500: 5;
		if(me.delayID) clearTimeout(me.delayID);
		me.delayID = setTimeout(function(){

			//見えてるカードを判別
			_news.selectVisibleCard(me.$list);

			//アニメーション表示
			_news.showCardWithAnime(me.$list);

		}, showDelay);
	},

	_layout:function(){
		var me = this;

		var rulerW = me.$cardRuler.width();
		var gutter = parseInt(me.$cardRuler.css("margin-right"), 10);
		if(me.rulerW!=rulerW) {
			//画像の高さ指定を削除
			me.$list.find(".cardInr .pic").css("height", "");
			me.$list.find(".cardInr .pic img").removeAttr("height");
		}
		me.rulerW = rulerW;

		//masonry
		me.msnry = new Masonry( me.$list[0], {
			columnWidth: rulerW,
			gutter: gutter,
			itemSelector: '.item',
			isAnimated: false,
			isInitLayout: true,
			isResizeBound: false
		});


	},

	_makeCard:function(item, delayTime){
		var me = this;

		var blog = item["blog"];

		var $tpl = me.$tpl_card_news_summary;
		if(blog=="profile") $tpl = me.$tpl_card_profile_summary_normal;
		else if(blog=="fanclub") $tpl = me.$tpl_card_fanclub;
		else if(blog=="service") $tpl = me.$tpl_card_service;

		var $card = $tpl.clone().appendTo(me.$list);
		if(me.hash1=="entry") $card.addClass("card-related");

		setTimeout(function(){
			me._initCard($card, item, false ) ;
		}, delayTime);
	},

	_initCard:function($card, item, isDetail){
		var me = this;
		var blog = item["blog"];

		/*  共通
		--------------------------------------------------*/

		//id
		$card.attr("data-id", item["id"]);
		$card.find(".btPrint").attr("data-id", item["id"]);

		//size
		if(item["card_size"]) $card.addClass("size-"+item["card_size"])

		//カテゴリー
		var cat = item["blog"] || "";
		$card.attr("data-cat", cat);
		cat = cat.substr(0,1).toUpperCase() + cat.substr(1);
		if(blog=="news" && item["category"]) cat += " - "+item["category"].join(",");
		$card.find(".cat").text(cat);
		if( !isDetail && (item["category"]||[] ).indexOf("pickup")>=0) $card.addClass("pickup");

		//date
		if(item["date"]) {
			var d = new Date(item["date"]);
			$card.find(".date span").text(d.getFullYear() +"."+ (d.getMonth()+1) +"."+ d.getDate() );
		}
		else $card.find(".date").remove();

		//URL
		var direct_url = item["direct_url"];
		if(direct_url) {
			//$card.addClass("card-direct");
			//$card.find("a.cardInr").attr("href", direct_url).attr("target", "_blank").addClass("btCardDirect").attr("data-id", item["id"]).attr("data-cat", $card.attr("data-cat")).attr("data-title", item["title"]);
			$card.find("a.cardInr").attr("href", direct_url).attr("target", "_self").attr("data-cat", $card.attr("data-cat")).attr("data-title", item["title"]);
		}

		//サムネイル画像
		if($card.find(".pic").length>0) {
			var thum = item["thum"];
			if(me.hash1=="entry") {
				//記事詳細の時のみ、同名画像ファイルをはじく
				if(me.displayImageIdx[thum] && !item["youtube_id"]) thum = null;
				me.displayImageIdx[thum] = true;
			}
			if(thum) {
				$card.find(".pic img").attr("src", thum);
				if(item["thum_w"]) {
					var picW = $card.find(".pic").width() || $card.find(".pic img").width();
					var picH = picW/item["thum_w"] * item["thum_h"];
					$card.find(".pic").css("height", picH);
					$card.find(".pic img").attr("height", picH);
				}
			}
			else {
				$card.find(".pic").remove();
				$card.addClass("noPic");
			}
		}

		//テキスト
		if(!isDetail) {
			var card_shoulder = item["card_shoulder"];
			if(card_shoulder && (item["category"]||[]).indexOf("beamie")>=0) card_shoulder += " (blog)";
			if(card_shoulder) $card.find(".shoulder").html(card_shoulder);
			else $card.find(".shoulder").remove();

			var card_title = item["card_title"];
			if(!card_title) {
				if(blog=="news") {
					item["talent"] = item["talent"] || [];
					item["program"] = item["program"] || [];
					card_title = item["talent"].join("・");
					if(!card_title) card_title = item["program"].join("・");
				}
				else if(blog=="related" || blog=="profile" || blog=="fanclub" || blog=="service") {
					card_title = item["title"];
				}
			}
			if(card_title) $card.find(".title").html(card_title);
			else $card.find(".title").remove();

			var card_lead = item["card_lead"];
			if(!card_lead) {
				if(blog=="news") {
					card_lead = item["title"];
				}
				else if(blog=="related" || blog=="fanclub" || blog=="service") {
					card_lead = item["body"];
				}
			}
			if(card_lead) $card.find(".lead").html(card_lead);
			else $card.find(".lead").remove();
		}

		//newマーク
		if(item["newmark"]) $card.addClass("new");
		if(item["newmark_hide"]) $card.removeClass("new");

		//テキスト非表示
		if(item["text_hide"]) {
			$card.addClass("noText");
			$card.find(".txts").remove();
		}

		//CLIP
		if(isDetail) {
			$card.find(".clip").attr("data-id", item["id"]);
			if(me._clip(item["id"])) $card.find(".clip").addClass("done");
		}


		/*  NEWSのカード
		--------------------------------------------------*/
		if(blog=="news") {

			if(isDetail) {
				if(item["image"]) {
					$card.find(".p img").attr("src", item["image"]);
					if(item["image_w"]!==undefined){
						if(item["image_w"]>item["image_h"]) $card.addClass("landscape");
						else $card.addClass("portrait");
					}
				}
				else $card.find(".p").remove();

				$card.find(".title").html(item["title"]);
				$card.find(".body").html(item["body"]);

				$card.find(".body").find("a").attr("target", "_blank");

				var talents = item["talent"] || [];
				var talent_urls = item["talent_url"] || [];
				var programs = talents.concat(item["tag"] || []);
				var program_urls = talent_urls.concat(item["tag_url"] || []);
				var i, len = programs.length;
				for (i = 0; i < len; i++) {
					if(programs[i] && program_urls[i]) {
						//$card.find(".links").append($('<li><a href="'+program_urls[i]+'" target="_blank">'+programs[i]+'</a></li>'))
						$card.find(".links").append($('<li><a href="'+program_urls[i]+'">'+programs[i]+'</a></li>'))
					}
				}

			} else {

				if(item["youtube_id"]) $card.addClass("channel")

			}

		}

		/*  PROFILEのカード
		--------------------------------------------------*/
		else if(blog=="profile") {

			if(isDetail) {
				var $profPic = $card.find(".profPic");
				var $profTxts = $card.find(".profTxts");

				$profPic.html('<img src="'+item["image"]+'" />');

				var picH = 300/item["image_w"] * item["image_h"];
				$profTxts.css("min-height", picH+10);

				$profTxts.find(".name-jp").html(item["title"]);
				$profTxts.find(".name-en").html(item["name_en"]);

				trace('item["memo"]:'+item["memo"])
				if(item["memo"]) $profTxts.find(".memo").html(item["memo"]);
				else $profTxts.find(".memo").remove();

				var $tpl_li_clear = $profTxts.find("ul li.clear").remove();
				var $tpl_li = $profTxts.find("ul li").remove();
				var $tpl_ul = $profTxts.find("ul").remove();

				var i, len = item["description"].length;
				for (i = 0; i < len; i++) {
					var obj = item["description"][i];
					var $ul = $tpl_ul.clone().appendTo($profTxts);
					var seq = 0;
					for(var key in obj) {
						var $li = $tpl_li.clone().appendTo($ul);
						$li.find(".m").html(key);
						$li.find(".t").html(obj[key]);
						if(obj[key].length>35) {
							$li.addClass("one");
							seq = 0;
						} else {
							seq++;
						}
						if(seq%2==0) $tpl_li_clear.clone().appendTo($ul);
					}
				}

				var i, len = item["links"].length;
				for (i = 0; i < len; i++) {
					var obj = item["links"][i];
					var title = obj["title"];
					title = '<div class="split"><span class="l">'+title.split(" - ")[0]+' -</span><span class="r">'+title.split(" - ")[1]+'</span></div>';
					var $li = $('<li><a href="'+obj["url"]+'" target="_blank">'+title+'</a></li>');
					$card.find(".links").append($li);
					$li.find(".r").css("margin-left", $li.find(".l").width()+5 );
				}


			} else {

				if(item["unit_name1"]) {
					$card.find(".txts").addClass("txts-combi");
					$card.find(".profile_name").html(
						item["title"] + '<br>' +
							'('+item["unit_name1"] + '・' + item["unit_name2"] +')'
					);
				} else {
					$card.find(".profile_name").html( item["title"] );
				}
				if(item["memo"]) $card.find(".memo").html( item["memo"] );

			}
		}

		/*  FANCLUBのカード
		 --------------------------------------------------*/
		else if(blog=="fanclub") {
			var cat = (item["category"]||[])[0];
			if(cat=="page") $card.find(".date").remove();
		}

	},

	_translateCatToJP:function(en){
		var me = this;
		var newsCatIdx = {
			"お知らせ": { "code": "announce", "en": "" },
			"メッセージ": { "code": "message", "en": "message" },
			"舞台": { "code": "stage", "en": "Stage" },
			"イベント・会見": { "code": "event", "en": "Event" },
			"ＣＭ": { "code": "cm", "en": "CM" },
			"雑誌": { "code": "magazine", "en": "Magazine" },
			"ＭＵＳＩＣ": { "code": "music", "en": "Music" },
			"ＤＶＤ": { "code": "dvd", "en": "DVD" },
			"映画": { "code": "movie", "en": "Movie" },
			"ＴＶ": { "code": "tv", "en": "TV" },
			"動画": { "code": "channel", "en": "Channel" },
			"Pick up": { "code": "pickup", "en": "Pick up" }
		}
		for(var key in newsCatIdx) {
			if(newsCatIdx[key]["code"]==en) return key;
		}
	},

	//詳細のソーシャルボタン
	_initSocials:function($detail, item){
		var me = this;

		var shareUrl = item["url"];

		var shareUrlHash = "http://www.oscarpro.co.jp/#/"+item["blog"]+"/entry/" + item["id"];
		var shareText = item["title"];

		//fb
		$detail.find(".fb").html('<iframe src="//www.facebook.com/plugins/like.php?href='+shareUrl+'&amp;send=false&amp;layout=button_count&amp;width=115&amp;show_faces=true&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden;" allowTransparency="true"></iframe>');

		//tw
		if(twttr) {
			twttr.widgets.createShareButton(
				shareUrl,
				$detail.find(".tw")[0],
				function(el){},
				{
					"text": shareText,
					"lang": "ja",
					"url": shareUrl,
					"counturl": shareUrl
				}
			);
		}
		//google
		gapi.plusone.render($detail.find(".gg")[0], {'href': shareUrl, 'size': 'medium'});

	},

	_clip:function(id, isClip){
		var me = this;
		var ids = $.cookie("oscar_clip") || "";
		var idArr = ids.split(",");
		var i, len = idArr.length;
		for (i = 0; i < len; i++) {
			idArr[i] = Number(idArr[i]);
		}

		//0が入ってしまうのを削除
		if(idArr.indexOf(0)>=0) idArr.splice( idArr.indexOf(0), 1 );

		if(id===undefined) return idArr;
		else if(isClip===undefined) return (idArr.indexOf(Number(id))>=0)? true: false;
		else {
			var hitIndex = idArr.indexOf(Number(id));
			var $clip = $(".clip[data-id="+id+"]");
			if(isClip) {
				if(hitIndex<0) idArr.push(id);
				$clip.addClass("done");
			} else {
				if(hitIndex>=0) idArr.splice(hitIndex,1);
				$clip.removeClass("done");
			}
			$.cookie("oscar_clip", idArr.join(","));

			//loading表示
			$clip.addClass("isClipLoading");
			setTimeout(function(){
				$clip.removeClass("isClipLoading");
			}, 400);
		}
	}

});




/* -------------------------------------------------------------------------------------

 on air

 ------------------------------------------------------------------------------------- */
app.top.OnAirManager = okb.EventDispatcher.extend({

	__construct:function($me){
		this.__super.__construct.apply(this, arguments)
		var me = this;
		me.$ = $me;

		//ミニナビ
		me.$mnav = $(".mnav");
		me.$tpl_mnav_week = me.$mnav.find(".li-week").remove();
		me.$tpl_mnav_month = me.$mnav.find(".li-month").remove();
		me.$tpl_mnav_date = me.$mnav.find(".li-date").remove();
		me.$tpl_mnav = me.$mnav.find("ul").remove();
		me.$mnav.on("click", "a", function(e){
			e.preventDefault();
			var archiveHref = $(this).attr("href").substr(2);
			var hash = "#/";
			hash += me.blog_name;
			hash += "/"+me.category;
			if(me.type) hash += "/"+me.type;
			if(archiveHref) hash += "/"+archiveHref;
			location.href = hash;
		})

		//
		me.$onairArea = $(".onairArea");
		me.$pool = me.$.find(".pool");
		me.$tpl_table_head = me.$.find(".table-head").remove();
		me.$tpl_table_normal = me.$.find(".table-normal").remove();
		me.$tpl_table_multi = me.$.find(".table-multi").remove();
		me.$tpl_table_line_last = me.$.find(".tableLine.last").remove();
		me.$tpl_table_line = me.$.find(".tableLine").remove();
		me.$tpl_block = me.$.find(".block").remove();
		me.$tpl_wrap = me.$.find(".wrap").remove();

		//resize
		me._resized = function(){
			me.$onairArea.css("min-height", Math.max(300, me.$mnav.find("ul").height()+10) );
		}
		_ctrl.$window.on("resize", function(){
			me._resized();
		})
		me._resized();
	},

	switchShow:function(isShow){
		var me = this;
		if(isShow) me.$.addClass("show");
		else me.$.removeClass("show");
	},

	hashChanged:function(isFirst, hashArr){
		var me = this;
		me.hashArr = hashArr;
		me.blog_name = hashArr[0];
		var hash1 = hashArr[1] || "regular"; //category
		var hash2 = hashArr[2]; //type | archive
		var hash3 = hashArr[3]; //archive

		me.pre_category = me.category;
		me.pre_type = me.type;
		me.pre_archive = me.archive;
		me.category = hash1;
		if(hash3) {
			me.archive = hash3;
		} else if(hash2) {
			if(hash2=="tv"||hash2=="radio"||hash2=="web") {
				me.type = hash2;
				me.archive = null;
			} else {
				me.archive = hash2;
			}
		} else {
			me.archive = null;
			me.type = null;
		}

		if(!isFirst) {
			_news.scrollToContent(500);
		}
		me._removeAll();
		me._loadData();
	},

	_removeAll:function(){
		var me = this;
		me.$pool.html("");
		if(me.currentXHR) me.currentXHR.abort();
	},

	_loadData:function(){
		var me = this;

		//loading
		_news.switchLoading(true);

		var vals = {};
		vals["category"] = me.category;
		if(me.type) vals["type"] = me.type;
		if(me.archive) vals["archive"] = me.archive;

		me.currentXHR = app.loadAPI("onair", vals, function(data){
			data = data["data"];
			if(me.category!=me.pre_category||me.type!=me.pre_type) me._makeMiniNav(data);
			me._switchActiveMiniNav();
			me._makeTables(data);
			me._showTables()
		})
	},

	_switchActiveMiniNav:function(){
		var me = this;

		$(".mnav li a").each(function(index){
			var $btn = $(this);
			var href = $btn.attr("href");
			if(href == "#/"+(me.archive||"")) $btn.addClass("on");
			else $btn.removeClass("on");
		})
	},

	_makeMiniNav:function(data){
		var me = this;

		me.$mnav.html("");

		var archive_list = data["archive_list"] || [];
		if(archive_list.length>0) {
			var $mnavWrap = me.$tpl_mnav.clone().appendTo(me.$mnav);
			var pre_year,pre_month;
			var weekArr = "sun mon tue wed thu fri sat".split(" ");
			var i, len = archive_list.length;
			for (i = 0; i < len; i++) {
				var code = archive_list[i];
				if(code.indexOf("20")==0) {
					var year = Number(code.split("-")[0]);
					var month = Number(code.split("-")[1]);
					var day = Number(code.split("-")[2]);
					var d = new Date(code.split("-").join("/"));
					var week = me._translateWeekByNum(d.getDay());
					if(pre_year!=year||pre_month!=month) {
						var $li_month = me.$tpl_mnav_month.clone().appendTo($mnavWrap);
						$li_month.find(".num").text(year);
						$li_month.find(".str").text(month);
					}
					var $li_date = me.$tpl_mnav_date.clone().appendTo($mnavWrap);
					$li_date.find(".num").text(day);
					$li_date.find(".str").text(week);
					$li_date.find("a").attr("href", "#/"+code)
					pre_year = year;
					pre_month = month;
				} else {
					var $li_week = me.$tpl_mnav_week.clone().appendTo($mnavWrap);
					$li_week.addClass("li-"+code)
						.find("a").attr("href", "#/"+code).text(code);
				}
			}
			$mnavWrap.addClass("show");
			me._resized();
		}
	},

	_makeTables:function(data){
		var me = this;
		var dataIdx = data["hash"];

		for(var type in dataIdx) {
			var hasProgram = false;

			//wrap
			var $wrap = me.$tpl_wrap.clone().appendTo(me.$pool);
			if(type=="tv") $wrap.find(".h-content-radio, .h-content-web").remove();
			else if(type=="radio") $wrap.find(".h-content-tv, .h-content-web").remove();
			else $wrap.find(".h-content-tv, .h-content-radio").remove();

			//block
			var blockIdx = dataIdx[type];
			for(var code in blockIdx) {

				//
				var $block = me.$tpl_block.clone().appendTo($wrap);

				//block - title
				var hThml = '';
				if(code.indexOf("20")==0) {
					var year = Number(code.split("-")[0]);
					var month = Number(code.split("-")[1]);
					var day = Number(code.split("-")[2]);
					var d = new Date(code.split("-").join("/"));
					var week = me._translateWeekByNum(d.getDay());
					hThml = '<img src="http://www.oscarpro.co.jp/assets/imgs/onair/sh-guest-'+week+'.png" />';
					hThml = '<span>'+ month + "." + day + '</span>' + hThml;
				} else {
					hThml = '<img src="http://www.oscarpro.co.jp/assets/imgs/onair/sh-regular-'+code+'.png" />';
				}
				$block.find(".h-white").html(hThml);

				//見出しtable
				me.$tpl_table_head.clone().appendTo($block);
				var $prevLine = me.$tpl_table_line.clone().appendTo($block);

				//各番組
				var list = blockIdx[code];
				var i, len = list.length;
				for (i = 0; i < len; i++) {
					var obj = list[i];
					hasProgram = true;

					//
					var talentArr = obj["talent"] || [];
					var $table = (talentArr.length>1? me.$tpl_table_multi: me.$tpl_table_normal).clone().appendTo($block);
					var $tpl_subRow = $table.find(".subRow").remove();
					var $row = $table.find("tr");

					if(obj["newmark"]) {
						$row.addClass("newmark");
						$prevLine.addClass("newmark");
					}

					$row.find(".cellTime").html(obj["onair_time"]);
					if(obj["station_url"]) {
						$row.find(".cellStation a").attr("href", obj["station_url"]).text(obj["station"]);
					} else {
						$row.find(".cellStation").html(obj["station"]);
					}
					if(obj["direct_url"]) {
						$row.find(".cellTitle a").attr("href", obj["direct_url"]).text(obj["title"]);
					} else {
						$row.find(".cellTitle").html(obj["title"]);
					}
					if(obj["station"]) {
						$row.find(".cellTitle").prepend('<span class="sp">[ '+obj["station"]+' ]</span>');
					}

					//cast
					$row.find("td[rowspan=2]").attr("rowspan", talentArr.length);

					var j, len2 = talentArr.length;
					for (j = 0; j < len2; j++) {
						var $tRow = $row;
						if(j>0) $tRow = $tpl_subRow.clone().appendTo($table)
						$tRow.find(".cellCast img").attr("src", obj["talent_thum"][j]);
						$tRow.find(".cellCast a").attr("href", obj["talent_url"][j]).text(obj["talent"][j]);
						$tRow.find(".cellRemarks").html(obj["talent_text"][j]);
					}

					//区切り
					$prevLine = ((i==len-1)? me.$tpl_table_line_last: me.$tpl_table_line).clone().appendTo($block);
				}
			}

			if(!hasProgram) $wrap.remove();
		}
	},

	_showTables:function(){
		var me = this;

		var $wrap = me.$pool.find(".wrap");
		//show
		if(_ctrl.ie678) {
			_news.switchLoading(false);//loading
			$wrap.removeClass("hide");
		} else {
			var showDelay = 500;
			if(me.showID) clearTimeout(me.showID);
			me.showID = setTimeout(function(){
				_news.switchLoading(false);//loading
				$wrap.removeClass("hide");
				_ctrl.tween( $wrap, {"alpha": 0, "y": 15}, {"alpha": 1, "y": 0}, 400, 0, TWEEN.Easing.Quadratic.InOut,
					function(){
					}, function(){
					} );
			}, showDelay);
		}
		//ie用ハック（フッタの下に隙間ができてしまうことがあるため）
		if(_ctrl.ie) {
			setTimeout(function(){
				me.$page.css("height", me.$page.height()-10 );
				setTimeout(function(){
					me.$page.css("height", "" );
				}, 1);
			}, 500);
		}
	},

	_translateWeekByNum:function(num){
		var me = this;
		if(!me.weekArr) me.weekArr = "sun mon tue wed thu fri sat".split(" ");
		return me.weekArr[num];
	},

	_translate:function(jp){
		var me = this;
		var transIdx = {
			"レギュラー出演": "regular",
			"ゲスト出演": "guest",
			"月曜日": "mon",
			"火曜日": "tue",
			"水曜日": "wed",
			"木曜日": "thu",
			"金曜日": "fri",
			"土曜日": "sat",
			"日曜日": "sun",
			"毎日": "everyday",
			"不定期": "irregular"
		}
		jp = (jp||'').split(" ").join("").split("\n").join("");
		return transIdx[jp];
	}

});



