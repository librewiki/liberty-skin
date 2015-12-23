var Base64 = {

            // private property
_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

          // public method for encoding
          encode : function (input) {
              var output = "";
              var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
              var i = 0;

              input = Base64._utf8_encode(input);

              while (i < input.length) {

                  chr1 = input.charCodeAt(i++);
                  chr2 = input.charCodeAt(i++);
                  chr3 = input.charCodeAt(i++);

                  enc1 = chr1 >> 2;
                  enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                  enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                  enc4 = chr3 & 63;

                  if (isNaN(chr2)) {
                      enc3 = enc4 = 64;
                  } else if (isNaN(chr3)) {
                      enc4 = 64;
                  }

                  output = output +
                      this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
                      this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

              }

              return output;
          },

          // public method for decoding
decode : function (input) {
             var output = "";
             var chr1, chr2, chr3;
             var enc1, enc2, enc3, enc4;
             var i = 0;

             input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

             while (i < input.length) {

                 enc1 = this._keyStr.indexOf(input.charAt(i++));
                 enc2 = this._keyStr.indexOf(input.charAt(i++));
                 enc3 = this._keyStr.indexOf(input.charAt(i++));
                 enc4 = this._keyStr.indexOf(input.charAt(i++));

                 chr1 = (enc1 << 2) | (enc2 >> 4);
                 chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                 chr3 = ((enc3 & 3) << 6) | enc4;

                 output = output + String.fromCharCode(chr1);

                 if (enc3 != 64) {
                     output = output + String.fromCharCode(chr2);
                 }
                 if (enc4 != 64) {
                     output = output + String.fromCharCode(chr3);
                 }

             }

             output = Base64._utf8_decode(output);

             return output;

         },

         // private method for UTF-8 encoding
_utf8_encode : function (string) {
                   string = string.replace(/\r\n/g,"\n");
                   var utftext = "";

                   for (var n = 0; n < string.length; n++) {

                       var c = string.charCodeAt(n);

                       if (c < 128) {
                           utftext += String.fromCharCode(c);
                       }
                       else if((c > 127) && (c < 2048)) {
                           utftext += String.fromCharCode((c >> 6) | 192);
                           utftext += String.fromCharCode((c & 63) | 128);
                       }
                       else {
                           utftext += String.fromCharCode((c >> 12) | 224);
                           utftext += String.fromCharCode(((c >> 6) & 63) | 128);
                           utftext += String.fromCharCode((c & 63) | 128);
                       }

                   }

                   return utftext;
               },

               // private method for UTF-8 decoding
_utf8_decode : function (utftext) {
                   var string = "";
                   var i = 0;
                   var c = c1 = c2 = 0;

                   while ( i < utftext.length ) {

                       c = utftext.charCodeAt(i);

                       if (c < 128) {
                           string += String.fromCharCode(c);
                           i++;
                       }
                       else if((c > 191) && (c < 224)) {
                           c2 = utftext.charCodeAt(i+1);
                           string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
                           i += 2;
                       }
                       else {
                           c2 = utftext.charCodeAt(i+1);
                           c3 = utftext.charCodeAt(i+2);
                           string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                           i += 3;
                       }

                   }

                   return string;
               },

URLEncode : function (string) {
                return escape(this._utf8_encode(string));
            },

            // public method for url decoding
URLDecode : function (string) {
                return this._utf8_decode(unescape(string));
            }
        };


var _rcnamespace = "0|4|10|12|14|1600";
//윈도우 사이즈에 따라 변경을 할지 않할 지 체크한다.
var isAllowRequestList = true;
//매개 변수 parent는 ul태그여야 합니다
function ShowAjaxRecentList(parent)
{
	function temp()
	{
		var getParameter =
		{
			action:"query",
			list:"recentchanges",
			rcprop:"title|timestamp",
			rcshow:"!bot|!redirect",
			rctype:"edit|new",
			rclimit:10,
			format:"json",
      rcnamespace:_rcnamespace,
      rctoponly:""
		};
		$.ajax(
		{
			url: mw.util.wikiScript("api"), // 호출 URL

			data:getParameter,
			'xhrFields': {
				'withCredentials': true
			},
			dataType:'json'

		}
			)
		.done(function(res)
		{
			var html = "";
			for(var i = 0 ; i < res.query.recentchanges.length ; i++)
			{
				var item = res.query.recentchanges[i];
        html += '<li><a class="recent-item" href = "/wiki/' + encodeURIComponent(item.title) + '" title="' + item.title +'">';
				var timestamp = item.timestamp;
				var timeStartIdx = timestamp.indexOf("T") + 1;
				var time = timestamp.substr(timeStartIdx,timestamp.length- timeStartIdx - 1);
				var hour =parseInt(time.substr(0,time.indexOf(":"))) ;
				hour += 9;
				hour = hour % 24;
				if(hour < 10)
				{
					hour = "0" + hour;
				}
				time = hour + time.substr(time.indexOf(":"),time.length - (time.indexOf(":") - 1));

				 html += "[" + time + "] ";
				 var text = "";

				if(item.type == "new")
				{
					text += "[New]";
				}
				text += item.title;
				if(text.length > 12)
				{
					text = text.substr(0,12);
					text +="...";
				}
				text =text.replace("[New]","<span class='new'>[New] </span>");
				html += text;
				html += "</a></li>"
			}
			if(parent != null)
			{
				$(parent).html(html);
			}
		});
	}
	temp();
}

/**
 * Vector-specific scripts
 */
var recentIntervalHandle = null;

jQuery( function ( $ ) {


	var width = $(window).width();
	if(width > 1023)
	{
		isAllowRequestList = true;
		ShowAjaxRecentList($("#live-recent-list"));
	}
	else
	{
		isAllowRequestList = false;
	}

	//만약에 화면의 사이즈가 작아 최근 변경글이 안보일 시, 갱신을 하지 않는다.
	$(window).resize(recentIntervalCheck);
} );


jQuery( function ( $ ) {
    $("#liberty-recent-tab1").click(function(e){
        $(this).addClass('active');
        $("#liberty-recent-tab2").removeClass('active');
        _rcnamespace = "0|4|10|12|14|1600";
        ShowAjaxRecentList($("#live-recent-list"));
    });

    $("#liberty-recent-tab2").click(function(e){
        $(this).addClass('active');
        $("#liberty-recent-tab1").removeClass('active');
        _rcnamespace = "1|3|5|7|9|11|13|15|2600|1601";
        ShowAjaxRecentList($("#live-recent-list"));
    });
} );

var recentIntervalCheck = function(){
	var width = $(window).width();
	if(width <= 1023){
		if(recentIntervalHandle != null){
			clearInterval(recentIntervalHandle);
			recentIntervalHandle = null;
		}
		isAllowRequestList = false;
	}else{
		if(recentIntervalHandle == null){
			recentIntervalHandle = setInterval(function(){
				ShowAjaxRecentList($("#live-recent-list"));
			},10 * 1000);
		}
		isAllowRequestList = true;
	}
}

jQuery(document).ready(function($){
	recentIntervalCheck();
});
