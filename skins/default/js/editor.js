var webEditor = {};

webEditor.init = function($) {
  var editor = ace.edit("editor");
  editor.setTheme("ace/theme/sqlserver");
  editor.session.setMode("ace/mode/html");
  editor.setOptions({
      autoScrollEditorIntoView: true,
      fontSize: '15px',
      tabSize: 2, 
      useSoftTabs: true
  });

  this.editor = editor;
  this.addEventListeners($);
  this.initSizeEditor();
};

webEditor.addEventListeners = function($) {
  $('#run-btn').on('click', function() {
    webEditor.run();
  });

  $('#reset-code-btn').on('click', function() {
    $('#result').contents().find('html').html("");
    webEditor.load("");

    var params = {
      table_of_content_srl: $('#current-view-info').attr('data-table-of-content-srl')
    };

    $.exec_json("webeditor.dispWebeditorSourceCode", params, function(result) { 
      var href = result.path;
      var code =  result.code;
      var srcPattern = /src=\"(?!http:\/\/)(.*)\"/g;
      var dataPattern = /data=\"(?!http:\/\/)(.*)\"/g;
      
      var hrefPattern = /[.\/]*(.*)\/.*[.]html/g;
      href = href.replace(hrefPattern,'$1');
      var relativeTo = window.location.href + "/" + href;
              
      code = code.replace(srcPattern,'src="'+relativeTo+'/$1"');
      code = code.replace(dataPattern,'src="'+relativeTo+'/$1"');
      webEditor.load(code); 

    });
  });

  $('#save-code-btn').on('click', function() {
    var params = {
      code: webEditor.getValue(),
      table_of_content_srl: $('#current-view-info').attr('data-table-of-content-srl')
    }

    console.dir(params);

    $.exec_json("webeditor.procWebeditorSaveSourceCode", params, function(result) { 
      alert("저장되었습니다");
    });
  });

  $('#dragbar').on('mousedown', function(e) {
    var prevX = e.clientX,
        prevY = e.clientY;

    $(document).on('mousemove', function(e) {
      e.preventDefault();
      var moveX = prevX - e.clientX,
          moveY = prevY - e.clientY;

      webEditor.resizeEditor(moveX, moveY);

      prevX = e.clientX;
      prevY = e.clientY;

    }).on('mouseup', function(e){
      $(document).off( "mousemove").off( "mouseup").off('mouseleave');
    }).on('mouseleave', function(e){
      $(document).off( "mousemove").off( "mouseup").off('mouseleave');
    });
  });

  webEditor.resizeEditor = function(moveX, moveY) {
    var MIN_WITH_RATIO = 30,
        containerWidth = $('#web-editor-container').width(),
        editorWidth = $('#editor').outerWidth(),
        resultWidth = $('#result').outerWidth(),
        editorWidthRatio = Math.floor(((editorWidth - moveX) / containerWidth * 100) * 100) / 100;
        resultWidthRatio = Math.floor(((resultWidth + moveX) / containerWidth * 100) * 100) / 100;
    
    if(editorWidthRatio >= MIN_WITH_RATIO && resultWidthRatio >= MIN_WITH_RATIO) {
      $('#editor').css('width', editorWidthRatio + "%");
      $('#result').css('width', resultWidthRatio + "%");
    }
  };

  webEditor.run = function() {
    var sourceCode = this.getValue();
    if($('#show-new-window').is(":checked")) {
      var w = window.open();
      w.document.writeln(sourceCode);
    } else {
      $('#result').contents().find('html').html(sourceCode);
    }
    
    // 

  };


  webEditor.initSizeEditor = function() {
    var containerWidth = $('#web-editor-container').width(),
        dragbarWidth = $('#dragbar').outerWidth(),
        resultWidthRatio = Math.floor((((containerWidth - dragbarWidth) / 2) / containerWidth * 100) * 100) / 100;
        editorWidthRatio = Math.floor((((containerWidth - dragbarWidth) / 2) / containerWidth * 100) * 100) / 100;

    $('#editor').css('width', editorWidthRatio + "%");
    $('#result').css('width', resultWidthRatio + "%");  
  };


  webEditor.load = function(data) {
    this.editor.setValue(data);
  }

  webEditor.getValue = function() {
    return this.editor.getValue();
  }  
  
};

