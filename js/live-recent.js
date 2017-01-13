$(function() {
  var documentNamespaces = '0|4|10|12|14|1600';
  var topicNamespaces = '1|3|5|7|9|11|13|15|2600|1601|1063';
  var isDocumentTab = true;

  $('#liberty-recent-tab1').click(function(e){
    $(this).addClass('active');
    $('#liberty-recent-tab2').removeClass('active');
    isDocumentTab = true;
    refreshLiveRecent();
  });

  $('#liberty-recent-tab2').click(function(e){
    $(this).addClass('active');
    $("#liberty-recent-tab1").removeClass('active');
    isDocumentTab = false;
    refreshLiveRecent();
  });

  function refreshLiveRecent() {
    if (!$('#live-recent-list').length || $('#live-recent-list').is(':hidden')) {
      return;
    }
    var getParameter = {
      action: 'query',
      list: 'recentchanges',
      rcprop: 'title|timestamp',
      rcshow: '!bot|!redirect',
      rctype: 'edit|new',
      rclimit: 10,
      format: 'json',
      rcnamespace: isDocumentTab? documentNamespaces : topicNamespaces,
      rctoponly: true
    };
    $.ajax({
      url: mw.util.wikiScript('api'),
      data: getParameter,
      xhrFields: {
        withCredentials: true
      },
      dataType:'json'
    })
    .then(function(data) {
      var recentChanges = data.query.recentchanges;
      var html = recentChanges.map(function(item) {
        var time = new Date(item.timestamp);
        var line = '<li><a class="recent-item" href = "/wiki/' + encodeURIComponent(item.title) + '" title="' + item.title +'">[' + timeFormat(time) + '] ';
        var text = '';
        if (item.type === 'new') {
          text += '[New] ';
        }
        text += item.title;
        if (text.length > 14) {
          text = text.substr(0, 14);
          text += '...';
        }
        text = text.replace('[New] ', '<span class="new">[New] </span>');
        line += text;
        line += '</a></li>';
        return line;
      }).join('\n');
      $('#live-recent-list').html(html);
    }, function() {
      return;
    });
  };

  function timeFormat(time) {
    let aDayAgo = new Date();
    aDayAgo.setDate(aDayAgo.getDate() - 1);
    if (time < aDayAgo) {
      return (time.getFullYear())+ '/' + (time.getMonth() + 1) + '/' + time.getDate();
    }
    var hour = time.getHours();
    var minute = time.getMinutes();
    var second = time.getSeconds();
    if (hour < 10) {
      hour = '0' + hour;
    }
    if (minute < 10) {
      minute = '0' + minute;
    }
    if (second < 10) {
      second = '0' + second;
    }
    return hour + ':' + minute + ':' + second;
  }

  setInterval(refreshLiveRecent, 10 * 1000);
  refreshLiveRecent();
});
