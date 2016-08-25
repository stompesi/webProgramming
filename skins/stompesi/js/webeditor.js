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

  this.path = "";
  this.editor = editor;
  this.addEventListeners($);
};

webEditor.addEventListeners = function($) {
  $('#run-btn').on('click', function(event) {
    event.preventDefault();
    webEditor.run();
  });

  $('#run-new-window-btn').on('click', function(event) {
    event.preventDefault();
    webEditor.runByNewWindow()
  });

  $('#reset-code-btn').on('click', function(event) {
    event.preventDefault();

    var params = { 
        table_of_content_srl: $('#side-menu').find('.active').attr('href')
      };

    $.exec_json("webeditor.dispWebeditorSourceCode", params, function(result) { 
      var code =  result.code;
      webEditor.setCode(code);
      webEditor.run();
    });
  });


  webEditor.setPath = function(path) {
    this.path = path;
  }

  webEditor.getPath = function() {
    return this.path;
  }  

  webEditor.setCode = function(code) {
    this.editor.setValue(code);
  }

  webEditor.getCode = function() {
    return this.editor.getValue();
  }  


  webEditor.codeConvert = function(code) {
    var currentPath = this.path;
  
    var srcPattern = /src\s*=\s*\"\s*(?!http:\/\/)(.+)\"/g;
    var dataPattern = /data=\"(?!http:\/\/)(.+)\"/g;
    var relativeTo = window.location.href + "/" + currentPath;
            
    code = code.replace(srcPattern,'src="'+relativeTo+'/$1"');
    code = code.replace(dataPattern,'src="'+relativeTo+'/$1"');
    return code;
  }

  webEditor.run = function() {
    var code = this.getCode();

    code = webEditor.codeConvert(code);


    $('#result').contents().find('html').html(code);
  } 

  webEditor.runByNewWindow = function() {
    var code = this.getCode();
    
    code = webEditor.codeConvert(code);

    var w = window.open();
    w.document.writeln(code);
  } 
};

