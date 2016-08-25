jQuery(document).ready(function($){
  $('#sync-menu-btn').on('click', function(event) {
    event.preventDefault();
    var params = {
      module_srl: $('#module_srl').val()
    };

    $.exec_json("webeditor.procWebeditorAdminSyncCodeBySourceCodeFolder", params, function(result) { 
      alert("변경되었습니다");
      location.reload();
    });
  });
});