

/* -------------------------------------------------------------------------------------

 本日の出演情報　＊newsに操作される

 ------------------------------------------------------------------------------------- */
app.TodayOnAir = okb.EventDispatcher.extend({


	__construct:function($me){
		this.__super.__construct.apply(this, arguments)
		var me = this;
		me.$ = $me;
		me.$outer = $(".todayCrop");
		me.$inr = $(".todayInr");

		me.$crop = me.$.find(".crop");
		me.$mover = me.$crop.find("ul");
		me.$tpl_li = me.$mover.find("li").remove();

		me.$btUp = me.$.find(".btUp");
		me.$btDown = me.$.find(".btDown");
		me.$btUp.on("click", function(e){
			e.preventDefault();
			me._goPrev();
		})
		me.$btDown.on("click", function(e){
			e.preventDefault();
			me._goNext();
		})

		me.isShow = false;

		me._loadData();
	},

	getHeight:function(){
		var me = this;
		return me.isShow? me.$inr.outerHeight(): 0;
	},
	getCropHeight:function(){
		var me = this;
		return me.$outer.outerHeight();
	},
	switchShow:function(isShow, isDirect){
		var me = this;
		if(isShow==me.isShow) return;
		me.isShow = isShow;
		var th = me.getHeight();
		var time = isDirect? 0: 500;
		me.$outer.stop().animate({"height":th}, time, "easeInOutQuart", function(){
			if(isShow) me.$outer.css("height", "auto");
		})
	},

	_loadData:function(){
		var me = this;

		var baseDate = new Date();
		var baseTimeStamp = baseDate.getTime();

		//見出し
		var week = "Sun Mon Tue Wed Thu Fri Sat".split(" ")[ baseDate.getDay() ];
		me.$.find("h3 span").text( (baseDate.getMonth()+1)+"/"+baseDate.getDate() + "("+week+")" )

		//load
		app.loadAPI("onair", {"category":"today"}, function(data){
			data = data["data"];
			var hash = data["hash"];

			var dataArr = [];
			for(var type in hash) {
				for(var code in hash[type]) {
					dataArr = dataArr.concat( hash[type][code] );
				}
			}

			function getTimestampFromStr(timeStr){
				if(!timeStr) return null;
				var year = baseDate.getFullYear();
				var month = baseDate.getMonth()+1;
				var date = baseDate.getDate();
				var hour = Number(timeStr.split(":")[0]);
				if(hour>=24) date++;
				hour = hour%24;
				var min = Number(timeStr.split(":")[1]);
				var d = new Date(year+"/"+month+"/"+date+" "+hour+":"+min);
				return d.getTime();
			}
			var i, len = dataArr.length;
			for (i = 0; i < len; i++) {
				var obj = dataArr[i];
				var timeStr = obj["onair_time"];
				if(!timeStr) continue;
				timeStr = timeStr.split("\s").join("");
				obj["time_start"] = getTimestampFromStr( timeStr.split("-")[0] );
				obj["time_end"] = getTimestampFromStr( timeStr.split("-")[1] );
			}
			dataArr.sort(function(a,b){ return a["time_start"]<b["time_start"]? -1: 1; })

			var nearInd = 0;
			var i, len = dataArr.length;
			for (i = 0; i < len; i++) {
				var obj = dataArr[i];
				var $li = me.$tpl_li.clone().appendTo(me.$mover);
				$li.find("a").attr("href", obj["direct_url"]||"" );
				if(obj["talent_thum"] && obj["talent_thum"].length>0) $li.find(".pic").html('<img src="'+obj["talent_thum"][0]+'" />');
				if(obj["onair_time"]) $li.find(".time .t").text( obj["onair_time"] );
				$li.find(".time .type").text( obj["type"] );
				$li.find(".time .type").text( obj["type"] );
				$li.find(".title").text( obj["title"] );
				if(obj["talent"] && obj["talent"].length>0) $li.find(".cast").text( obj["talent"][0] );

				var criteriaTime = obj["time_end"] || obj["time_start"];
				if(criteriaTime>=baseTimeStamp && nearInd==0) nearInd = i;

				if(baseTimeStamp>=obj["time_start"]) {
					if(obj["time_end"]) {
						if(baseTimeStamp<=obj["time_end"]) $li.addClass("now");
					} else {
						$li.addClass("now");
					}
				}
			}

			me.startInd = nearInd;

			//リサイズ検知とともにinit
			var preCropH = 0;
			me._resized = function(){
				var cropH = me.$crop.height();
				if(preCropH==cropH) return;
				preCropH = cropH;
				me._initCarrousel();
			}
			_ctrl.$window.on("resize", function(){
				me._resized();
			})
			me._resized();

		})
	},

	_initCarrousel:function(){
		var me = this;

		me.cropH = me.$crop.height() - 1;
		me.colH = me.$mover.find("li").outerHeight();
		me.colNum = Math.round(me.cropH/me.colH);
		me.listCnt = me.$mover.find("li").length;
		me.maxPage = Math.max(0, me.listCnt-me.colNum);

		me.num=-1;
		me._move(me.startInd, true);
	},

	_goNext:function(){
		var me = this;
		me._move(me.num+me.colNum);
	},

	_goPrev:function(){
		var me = this;
		me._move(me.num-me.colNum);
	},

	_move:function(num, isDirect){
		var me = this;
		if(num>me.maxPage) num=me.maxPage;
		if(num<0) num=0;
		if(num==me.num) return;
		me.num = num;

		var ty = - me.colH*num;
		var time = isDirect? 0: 400;
		me.$mover.stop().animate({"top":ty}, time, "easeInOutQuart");

		if(me.num==0) me.$btUp.addClass("off");
		else me.$btUp.removeClass("off");
		if(me.num==me.maxPage) me.$btDown.addClass("off");
		else me.$btDown.removeClass("off");
	}

});





/* -------------------------------------------------------------------------------------

 Side CNav

 ------------------------------------------------------------------------------------- */
app.SideCNav = okb.EventDispatcher.extend({

	EV_TOGGLE_MENU:"evToggleMenu",

	__construct:function($me, isPC){
		this.__super.__construct.apply(this, arguments)
		var me = this;
		me.$ = $me;

		me.isPC = isPC;

		me.$gnavLi = $(".gnav li");

		//ハッシュの変更をひろう
		_ctrl.$window.hashchange(function(e){
			me._hashChanged();
		})
		me._hashChanged(true);


		//knob
		me.$.find(".knob").each(function(index){
			$(this).on("click", function(e){
				e.preventDefault();
				me._switchOpenMenu( me.menuNum==index? -1: index );
			})
		})


		//NEWS - カレンダー
		me.$calender = me.$.find(".news-calender");
		if(me.$calender.length>0) {
			var now = new Date();
			me.nowYear = now.getFullYear();
			me.nowMonth = now.getMonth()+1;
			me.nowDay = now.getDate();
			me.$table = me.$calender.find("table");
			me.tableDefHtml = me.$table.html();
			me.$nowMonth = me.$calender.find(".nowMonth");
			me.$btPrev = me.$calender.find(".btPrev a").on("click", function(e){
				e.preventDefault();
				me._showCalender(me.num-1);
			})
			me.$btNext = me.$calender.find(".btNext a").on("click", function(e){
				e.preventDefault();
				me._showCalender(me.num+1);
			})
			me._showCalender(0);
		}


		//PROFILE - 誕生日
		var date = new Date();
		me.$.find(".li-profile-birthday a").text( "誕生日 "+(date.getMonth()+1)+"/"+date.getDate() );


		//SPの場合、一回目開くときは閉じた状態でちょっと待ってから開く
		if(!isPC) {
			var isDone = false;
			_spMenu.bind(_spMenu.EV_OPEN, function(e){
				if(isDone) return;
				isDone = true;

				var tmpMenuNum = me.menuNum;
				me._switchOpenMenu(-1, true, true);
				me.introDelayID = setTimeout(function(){
					me._switchOpenMenu(tmpMenuNum, false, true);
				}, 1200);
			})
		}

	},

	_hashChanged:function(isFirst){
		var me = this;

		if(me.introDelayID) clearTimeout(me.introDelayID);

		var hash = location.hash || "#";
		if(hash.indexOf("#/")<0) hash = "#/";
		if(hash=="#/") hash = "#/news";
		var hash1 = hash.split("/")[1];
		var hash2 = hash.split("/")[2];
		me.hash = hash;

		//グロナビ
		me.$gnavLi.each(function(index){
			var $li = $(this);
			var $a = $li.find("a");
			var href = $a.attr("href").split("#")[1];
			if(location.hash.indexOf(href)>=0) $li.addClass("on");
			else $li.removeClass("on");
		})

		//カテゴリナビ
		me.$.find(".catGroup").each(function(index){
			var $catGroup = $(this);
			var $h = $catGroup.find(".h a");
			var $localMenu = $catGroup.find(".localMenu");
			var $localMenuInr = $catGroup.find(".localMenuInr");
			if($h.attr("href").indexOf(hash1)>=0) {
				$h.addClass("ac");
				var localHitIndex = 0;
				$localMenu.find("ul li a")
					.clearQueue().stop()
					.each(function(index2){
						var href = $(this).attr("href").split("#")[1];
						if(hash.indexOf(href)>=0) localHitIndex = index2;
					})
					.removeClass("on loading")
				if(hash2!="entry") {
					$localMenu.clearQueue().stop().find("ul li a").eq(localHitIndex).addClass("on loading").delay(900).queue(function(){
						$(this).removeClass("loading");
					})
				}
				//メニュー開閉
				me._switchOpenMenu(index, isFirst, true);
			} else {
				$h.removeClass("ac");
				$localMenu.clearQueue().stop().find("ul li a").removeClass("on loading")
			}
		})
	},


	_switchOpenMenu:function(num, isDirect, noScroll){
		var me = this;
		if(num==me.menuNum) return;
		me.menuNum = num;

		//hero / today 閉じる
		if(!isDirect && !noScroll) {
			_hero.switchShow(false);
			_todayOnAir.switchShow(false);
		}

		me.$.find(".catGroup").each(function(index){
			var $catGroup = $(this);
			var $h = $catGroup.find(".h a");
			var $localMenu = $catGroup.find(".localMenu");
			var $localMenuInr = $catGroup.find(".localMenuInr");
			var nowH = parseInt($localMenu.css("height"), 10);
			var destH = index==num? $localMenuInr.height(): 0;
			if(nowH!=destH) {
				var time = isDirect? 0: 500;
				$localMenu.stop().animate({"height":destH}, time, "easeInOutQuart", function(){
					if(destH>0) $localMenu.css("height", "auto");
				})
				if(!isDirect && me.isPC) {
					var ty = me.$.offset().top - 60;
					_news.scrollToContent(500);
				}
			}
			if(index==num) {
				$h.addClass("on");
			} else {
				$h.removeClass("on");
			}
		})
	},


	_showCalender:function(num){
		var me = this;

		if(me.isLoading) return;
		if(num==me.num) return;
		me.num = num;

		var month = me.nowMonth + me.num;
		var year = me.nowYear + Math.floor((month-1)/12);
		month = (month-1)%12+1;
		if(month<=0) month += 12;
		var weekList = ["日","月","火","水","木","金","土"];
		var dateCntList = [31,28,31,30,31,30,31,31,30,31,30,31];
		if (((year%4)==0 && (year%100)!=0) || (year%400)==0) dateCntList[1] = 29;//うるう年
		var dateCnt = dateCntList[month-1];
		var baseDate = new Date(year+"/"+month+"/"+1);
		var baseWeek = baseDate.getDay();

		me.isLoading = true;
		app.loadAPI("calender", {"month": year+"-"+month}, function(data){
			me.isLoading = false;
			var eventList = data["data"]["list"] || [];
			var tableHtml = me.tableDefHtml;
			//前半の空白セル
			var cellArr = new Array(baseWeek);
			//日付セル
			var i, len = dateCnt;
			for (i = 0; i < len; i++) {
				cellArr.push(i+1);
			}
			//後半の空白セル
			var plusCellCnt = 7-(cellArr.length)%7;
			if(plusCellCnt==7) plusCellCnt = 0;
			len = plusCellCnt;
			for (i = 0; i < len; i++) {
				cellArr.push(null);
			}
			//セルの生成
			var rowCnt = 0;
			len = cellArr.length;
			for (i = 0; i < len; i++) {
				if(rowCnt==0) tableHtml += '<tr>';
				var date = cellArr[i];
				if(date) {
					if(eventList.indexOf(date)>=0) tableHtml += '<td><a href="#/news/'+year+'-'+month+'-'+date+'">'+date+'</a></td>';
					else tableHtml += '<td><span>'+date+'</span></td>';
				} else {
					tableHtml += '<td><span></span></td>';
				}
				rowCnt++;
				if(rowCnt>=7) {
					tableHtml += '</tr>';
					rowCnt=0;
				}
			}
			me.$table.html(tableHtml);
			//
			me.$nowMonth.text(month+"月 "+year);
			me.$btPrev.find("span").text( month-1==0? 12: month-1 );
			me.$btNext.find("span").text( month+1==13? 1: month+1 );
		})
	}

});