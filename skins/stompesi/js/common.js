jQuery(document).ready(function($){
  // $('section.container').removeClass('container');
  webEditor.init($);

  
  $('#side-menu').on('click', 'a', function(event) {
    event.preventDefault();
  
    // ㅁㄴㅇㄹ

    $('#side-menu').find('.active').removeClass('active');
    $(this).addClass('active');
  
   var params = { 
        table_of_content_srl: $(this).attr('href'),
        title: $(this).text()
      };

    $.exec_json("webeditor.dispWebeditorSourceCode", params, function(result) { 
      var code =  result.code;
      webEditor.setCode(code);
      webEditor.run();
      webEditor.setPath(result.path);
      // alert(webEditor.getPath());
      $('.information').find('.panel-title').text(result.title);
    });

  });

  $('.chapter-container').on('click', 'a', function (event) {
    event.preventDefault();

    $('#chapter-lsit').find('.active').removeClass('active');
    $(this).addClass('active');

    var params = {
      module_srl: $('#module_srl').val(),
      parent_table_of_content_srl: $(this).attr('href')
    };
    $.exec_json("webeditor.dispWebeditorTableOfContents", params, function(result) { 
      var liHtml = '<li style="padding-left: 15px; margin-top: 10px; margin-bottom: 10px; font-size: 30px;font-weight: bold;border: 1px solid #FF5252;border-radius: 10px;background: #FF5252;color: white;">' + result.chapter.title + '</li>'
      var chapterList = result.chapterList;
      for(var index in chapterList) {
        liHtml += '<li><a href="'+ chapterList[index].table_of_content_srl + '">' + chapterList[index].title + '</a></li>';
      }
      $('#side-menu > ul').html(liHtml);
    });
  });

  $('#type-list').on('click', 'a', function (event) {
    event.preventDefault();

    $('#type-list').find('.active').removeClass('active');
    $(this).addClass('active');
  });

  $('.chapter-container').find('a:first').click();

});