jQuery(document).ready(function($){
  $('#sync-menu-btn').on('click', function(event) {
    event.preventDefault();
    $.exec_json("webeditor.procWebeditorAdminSyncCodeBySourceCodeFolder",{}, function(result) { 
      alert("변경되었습니다");
      location.reload();
    });
  });
});