var sideMenu = {};

sideMenu.init = function($) {
  this.isSideMenuOpen = false;
  this.addEventListeners($);
};

sideMenu.addEventListeners = function($) {
  var isSideMenuOpen = false;

  $('#side-menu').on('click', '[data-event-click-item]', function(event) {
    event.preventDefault();

    var role = $(this).attr('rel');

    if(role === 'folder') {
      sideMenu.toggleFolder(this);
    } else {
      var params = { 
          table_of_content_srl: $(this).parent().attr('data-table-of-content-srl'),
          title: $(this).parent().attr('data-title')
        };

      sideMenu.loadFile(params);
    } 
  });


  $('#menu-btn, #close-btn').on('click', function() {
    sideMenu.toggleMenu();
  });

  sideMenu.toggleFolder = function(target) {
    var ul = $(target).next(),
        icon = $(target).children('.glyphicon');
        
    icon.toggleClass('glyphicon-folder-open');
    icon.toggleClass('glyphicon-folder-close');
    ul.toggle();
  };

  sideMenu.loadFile = function(params) {
    $.exec_json("webeditor.dispWebeditorSourceCode", params, function(result) { 
      console.dir(result);
      var href = result.path;
      var code =  result.code;
      var srcPattern = /src\s*=\s*\"\s*(?!http:\/\/)(.+)\"/g;
      var dataPattern = /data=\"(?!http:\/\/)(.+)\"/g;
      var hrefPattern = /[.\/]*(.*)\/.*[.]html/g;
      href = href.replace(hrefPattern,'$1');
      var relativeTo = window.location.href + "/" + href;
              
      code = code.replace(srcPattern,'src="'+relativeTo+'/$1"');
      code = code.replace(dataPattern,'src="'+relativeTo+'/$1"');

      $('#current-view-info').text(params.title);
      $('#current-view-info').attr('data-table-of-content-srl', params.table_of_content_srl);

      webEditor.load(code); 
    });
  };

  sideMenu.toggleMenu = function() {
    
    if(this.isSideMenuOpen) {
      var COLOSE_WIDTH = 0;
      
      $("#side-menu").width(COLOSE_WIDTH);
      $("#web-editor-container").css('margin-left', COLOSE_WIDTH);
      this.isSideMenuOpen = false;
    } else {
      var OEPN_WIDTH = 250;

      $("#side-menu").width(OEPN_WIDTH);
      $("#web-editor-container").css('margin-left', OEPN_WIDTH);
      this.isSideMenuOpen = true;
    }
  };
};

