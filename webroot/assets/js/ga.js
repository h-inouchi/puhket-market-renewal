
/* ------------------------------------------------------------------------------------------------------

Google  Analrytics

------------------------------------------------------------------------------------------------------ */


<!-- util functions -->
var GA = {
	trackPage: function(page, title){
		if(GA.currentPage==page) return;
		if(page) {
			GA.currentPage = page;
			var obj = {page: page};
			if(title) obj["title"] = title + " | " + GA.defaultTitle;
			_gaq.push(['_trackPageview', obj]);
		}
		else {
			GA.currentPage = location.pathname;
			_gaq.push(['_trackPageview']);
		}
	},
	trackEvent: function(category, action, label){
		_gaq.push(['_trackEvent', category, action, label ]);
	}
}
GA.currentPage ="";
GA.defaultTitle = document.title;



<!-- Google Analytics Tracking Code -->
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-76970893-1']);
if(location.pathname!="/") {
	GA.trackPage(location.pathname);
}


(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

