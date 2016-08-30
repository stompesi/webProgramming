var webEditor = {};
var iframeGlobalProps = [];
var globalProps = [ ];

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
  editor.$blockScrolling = 1;
  readGlobalProps();
  iframeGlobalProps = Object.getOwnPropertyNames(window.document.getElementById("result").contentWindow);
  this.path = "";
  this.editor = editor;
  this.addEventListeners($);
};

webEditor.addEventListeners = function($) {
  $('#run').on('click', function(event) {
    event.preventDefault();
    var mode = $(this).attr('data-event');

    if(mode === 'run-current-window') {
      webEditor.run();
    } else {
      webEditor.runByNewWindow();  
    }    
  });

  $('#select-run-mode').on('click', 'a', function(event) {
    event.preventDefault();
    var mode = $(this).attr('data-event');
    var text = $(this).text();
    
    $('#run').text(text);
    $('#run').attr('data-event', mode);
    $('#run').click();
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
    this.editor.setValue(code, -1);
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
    
    var functionPattern = /function\s*(.*)\(\)\s*{/g;
    var documentPattern = /[^.](document)./g;

    code = code.replace(documentPattern,'window.document.getElementById("result").contentWindow.$1.');

    var newEntries = findNewIframeEntries();
    for(var index in newEntries) {
      delete top.document.getElementById("result").contentWindow[newEntries[index]];
    }

    var newEntries = findNewEntries();
    for(var index in newEntries) {
      // top.document.getElementById("result").contentWindow[newEntries[index]] = top[newEntries[index]];
      delete top[newEntries[index]];
    }

    
    $('#result').contents().find('html').html(code);

    var newEntries = findNewEntries();
    for(var index in newEntries) {
      top.document.getElementById("result").contentWindow[newEntries[index]] = top[newEntries[index]];
      // delete window[newEntries[index]];
    }
  } 

  webEditor.runByNewWindow = function() {
    var code = this.getCode();
    
    code = webEditor.codeConvert(code);

    var w = window.open();
    w.document.writeln(code);
  } 

  
};



function findNewIframeEntries() {
  iframeGlobalProps

  var currentPropList = Object.getOwnPropertyNames(top.document.getElementById("result").contentWindow);

    return currentPropList.filter( findDuplicate );

    function findDuplicate( propName ) {
        return iframeGlobalProps.indexOf( propName ) === -1;
    }
}

function readGlobalProps() {
    globalProps = Object.getOwnPropertyNames(top);
}

function findNewEntries(target) {
    var currentPropList = Object.getOwnPropertyNames(top);

    return currentPropList.filter( findDuplicate );

    function findDuplicate( propName ) {
        return globalProps.indexOf( propName ) === -1;
    }
}