sideMenu.createdItemCount = 0;
sideMenu.changedListArray = {};
sideMenu.deletedListArray = {};

sideMenu.createdItemListArray = [];

sideMenu.addAdminEventListeners = function($) {
  $('#sortable-ul').on('click', '.del', function() {
    var answer = confirm("삭제하시겠습니까? \n(하위 모든 폴더도 다같이 삭제됩니다.)");
    
    if(answer) {
      var currentFolderSrl = $(this).parent().attr('data-parent-table-of-content-srl');

      $(this).parent().remove();
      sideMenu.updateFilePosition('[data-table-of-content-srl='+currentFolderSrl+']', sideMenu.changedListArray);   

      var liObject = {
        table_of_content_srl: $(this).parent().attr('data-table-of-content-srl'),
      };

      sideMenu.deletedListArray[liObject.table_of_content_srl] = liObject.table_of_content_srl;
      console.dir(sideMenu.deletedListArray);
    }
  });

  $('#reset-menu-btn').on('click', function() {
    var answer = confirm("리셋 하시겠습니까? \n(수정했던 및 추가했던 모든 사항은 모두 초기화됩니다.)");
    if(answer) {
      if(sideMenu.createdItemListArray.length == 0) {
        location.reload();
      } else {

        $.exec_json("webeditor.procWebeditorAdminDeleteTableOfContents",{table_of_content_srls: sideMenu.createdItemListArray}, function(result) { 
          location.reload();
        }); 
      }
    }
  });

  $('#save-menu-btn').on('click', function() {

    var changedTableOfContentsArray = [],
        deletedTableOfContentsArray = [],
        changedTableOfContentsObject = sideMenu.changedListArray,
        deletedTableOfContentsObject = sideMenu.deletedListArray;
    
    for(var key in changedTableOfContentsObject) { 
      changedTableOfContentsArray.push(changedTableOfContentsObject[key]); 
    }

    for(var key in deletedTableOfContentsObject) { 
      deletedTableOfContentsArray.push(deletedTableOfContentsObject[key]); 
    }

    console.dir(changedTableOfContentsArray);

    $.exec_json("webeditor.procWebeditorAdminChangeTableOfContents",{
      changed_table_of_contents: changedTableOfContentsArray,
      deleted_table_of_content_srls: deletedTableOfContentsArray

    }, function(result) { 
      alert("변경되었습니다");
      sideMenu.changedListArray = {};
      location.reload();
    }); 

   // $.exec_json("webeditor.procwebeditorAdminSyncCodeBySourceCodeFolder",{table_of_contents: tableOfContents}, function(result) { 
   //    alert("변경되었습니다");
   //    location.reload();
   //  });
  });

  $('#sync-menu-btn').on('click', function() {
    $.exec_json("webeditor.procWebeditorAdminSyncCodeBySourceCodeFolder",{}, function(result) { 
      alert("변경되었습니다");
      location.reload();
    });
  });

  $('#add-folder-btn, #add-file-btn').on('click', function() {
    $('#add-form').show();
    $('#add-btn').attr('data-add-form', $(this).attr('data-add-form'));    
  });

  $('#add-btn').on('click', function() {
    var addForm = $(this).attr('data-add-form'),
        form = $('#' + addForm).children().clone(),
        title = $(this).parent().prev().val(),
        location = $('#sortable-ul').children().size();


    var parens = {
      type: form.children('a').attr('rel'),  
      location: location,
      parent_table_of_content_srl: "0",
      title: title
    };

    $.exec_json("webeditor.procWebeditorAdminInsertTableOfContent",parens, function(result) { 

      form.attr('data-table-of-content-srl', result.table_of_content_srl);
      form.attr('data-parent-table-of-content-srl', "0");
      form.attr('data-location', location);
      form.attr('data-title', result.title);
      form.find('.title').text(result.title);
      
      sideMenu.createdItemListArray.push(result.table_of_content_srl);

      $('#sortable-ul').append(form);
      $('#add-form').hide();
      $(this).parent().prev().val("");
      
    });
  });

  ///-------------------------------------------------------------------

  sideMenu.makesortable = function() {
    $( ".folder" ).sortable({
      connectWith: ".folder",
      // create: function (event, ui) {
      //   debugger;
      //   $()
      // },
      stop: function(event, ui) {
        // debugger;
        sideMenu.sort(ui);

        var prevFolderSrl = ui.item.attr('data-parent-table-of-content-srl');
            currentFolderSrl = ui.item.parent().closest('li').attr('data-table-of-content-srl') || "0";
        
        if(prevFolderSrl == currentFolderSrl) {
          sideMenu.updateFilePosition('[data-table-of-content-srl='+currentFolderSrl+']', sideMenu.changedListArray);   
        } else {
          sideMenu.updateFilePosition('[data-table-of-content-srl='+currentFolderSrl+']', sideMenu.changedListArray);   
          sideMenu.updateFilePosition('[data-table-of-content-srl='+prevFolderSrl+']', sideMenu.changedListArray);   
        }
      }
    }).disableSelection();
  };

  sideMenu.sort = function(ui) {
    

    var listitems = ui.item.parent('ul').children();
    listitems.sort(function (a, b) {
      
        if ($(a).children('a').attr('rel') == 'folder' && $(b).children('a').attr('rel') == 'file') {
          return -1;
        }

        if ($(a).children('a').attr('rel') == 'file' && $(b).children('a').attr('rel') == 'folder') {
          return 1;
        }


        return ($(a).attr('data-title').toUpperCase() > $(b).attr('data-title').toUpperCase())  ? 1 : -1;
    });
    ui.item.parent('ul').html(listitems);
    sideMenu.makesortable();

};

  sideMenu.updateFilePosition = function(target, list) {
    var table_of_content_srl = $(target).attr("data-table-of-content-srl");

    $(target).children('ul').children('li').each(function(idx, val) {
      console.log("table_of_content_srl: ", + table_of_content_srl + "  location: " + idx);
      $(this).attr('data-parent-table-of-content-srl', table_of_content_srl);
      $(this).attr('data-location', idx);
      var tableOfContentSrl = $(this).attr('data-table-of-content-srl');
      var liObject = {
        table_of_content_srl: tableOfContentSrl,
        location: idx,
        parent_table_of_content_srl: table_of_content_srl,
        title: $(this).attr('data-title')
      };

      list[tableOfContentSrl] = liObject;
    });
  };

  sideMenu.createListArray = function() {
    var listArray = [];
    sideMenu.createFileArray('#sortable-ul', listArray);
    return listArray;
  }

  sideMenu.creatFolderArray = function(target, listArray) {
    $(target).children('ul').each(function(idx, val){
      sideMenu.createFileArray(this, listArray);
    });
  };

  sideMenu.createFileArray = function(target, listArray) {
    $(target).children('li').each(function(idx, val){
      var liObject = {
        table_of_content_srl: $(this).attr('data-table-of-content-srl'),
        title: $(this).attr('data-title'),
        location: $(this).attr('data-location'),
        parent_table_of_content_srl: $(this).attr('data-parent-table-of-content-srl')
      };

      var hasSubList = $(this).children('ul').size() !== 0;
      if(hasSubList) {
        sideMenu.creatFolderArray(this, listArray);
      }
      listArray.push(liObject);
    });
  };


  sideMenu.createListObject = function() {
    var listObject = {
      childrens: []
    };

    sideMenu.createFileObject('#sortable-ul', listObject);
    return listObject;
  };

  sideMenu.creatFolderObject = function(target, parentObject) {
    $(target).children('ul').each(function(idx, val){
      sideMenu.createFileObject(this, parentObject);
    });
  };

  sideMenu.createFileObject = function(target, parentObject) {
    $(target).children('li').each(function(idx, val){
      var liObject = {
        table_of_content_srl: $(this).attr('data-table-of-content-srl'),
        title: $(this).attr('data-title'),
        parent_table_of_content_srl: $(this).attr('data-parent-table-of-content-srl'),
        location: $(this).attr('data-location')
      };

      var hasSubList = $(this).children('ul').size() !== 0;
      if(hasSubList) {
        liObject.childrens = [];
        sideMenu.creatFolderObject(this, liObject);
      }
      parentObject.childrens.push(liObject);
    });
  };
};

jQuery(document).ready(function($){
  sideMenu.addAdminEventListeners($);
  sideMenu.makesortable();
  $('.del').show();
});