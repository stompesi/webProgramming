<?php
// error_log( print_R($table_of_contents,TRUE) );
  class webeditorAdminController extends webeditor {

    function init() {}

    public function procWebeditorAdminChangeTableOfContents() {
      // $module_srl = Context::get('module_srl');
      // error_log($module_srl);
      
      // if (!$module_srl) { return; }
    
      // $oModuleModel = getModel('module');
      // $config = $oModuleModel->getModulePartConfig('webeditor', $module_srl);    

      // $source_code_folder_path = sprintf('%s%s', $this->module_path, $config->path);

      // $oWebEditorAdminModel = getAdminModel('webeditor');
      // $oWebEditorModel = getModel('webeditor');
      // $changed_table_of_contents = Context::get('changed_table_of_contents');
      // $deleted_table_of_content_srls = Context::get('deleted_table_of_content_srls');

    
      // foreach ($changed_table_of_contents as $changed_table_of_content) {
      //   $oWebEditorAdminModel->updateTableOfContent($changed_table_of_content);
      // }
      
      // $converted_path_list = new StdClass();
      // $this->syncTableOfContentByWeb("0", $source_code_folder_path, $converted_path_list);

      // error_log( print_R($deleted_table_of_content_srls,TRUE) );
      // foreach ($deleted_table_of_content_srls as $deleted_table_of_content_srl) {
      //   $output = $oWebEditorModel->getWebeditorTableOfContentByTableOfContentSrl($deleted_table_of_content_srl);

      //   error_log( print_R($output,TRUE) );
      //   error_log($output->data->path);

      //   if(file_exists($output->data->path)) {
      //     @chmod($output->data->path, 0777 );
      //     if($output->data->type == "folder") {
      //       error_log("폴더삭제");
      //       $this->del($output->data->path);
      //       $oWebEditorAdminModel->deleteTableOfContentsInFolder($deleted_table_of_content_srl);
      //     } else {
      //       error_log("파일삭제");
      //       @unlink($output->data->path);
      //     }
      //   }
      //   $oWebEditorAdminModel->deleteTableOfContent($deleted_table_of_content_srl);
      // }
    } 

    function del($dir) {
      // $result=array_diff(scandir($dir),array('.','..'));
      // foreach($result as $item) {
      //   if(!@unlink($dir.'/'.$item)){
      //     $this->del($dir.'/'.$item);
      //   }
      // }
      // rmdir($dir);
    }

    function syncTableOfContentByWeb($parent_table_of_content_srl, $to_folder_path, $converted_path_list) {
      // $oWebEditorModel = getModel('webeditor');
      // $oWebEditorAdminModel = getAdminModel('webeditor');

      // $output = $oWebEditorModel->getTableOfContentsInFolder($module_srl, $parent_table_of_content_srl);

      // foreach($output->data as $item) {
      //   $prev_parent_path = dirname($item->path);


      //   if($item->type =="folder") {
      //     $to_path = $to_folder_path.'/'.$item->title;
      //     error_log('to_path: '.$to_path);

      //     if($converted_path_list->{$prev_parent_path}) {
      //       $from_path = $prev_parent_path.'/'.$item->title;
      //       error_log('변경전 from_path: '.$from_path);

      //       $from_path = $converted_path_list->{$prev_parent_path}.'/'.$item->title;
      //       error_log('변경후 from_path: '.$from_path);
      //     } else {
      //       $from_path = $prev_parent_path.'/'.$item->title;
      //       error_log('변경 x from_path: '.$from_path);
      //     }

      //     if(dirname($item->path) == $to_folder_path) {
      //       error_log("not move");
      //       $this->syncTableOfContentByWeb($item->table_of_content_srl, $to_path, $converted_path_list);
      //     } else {

      //       $converted_path_list->{$prev_parent_path.'/'.$item->title} = $to_path;

      //       if(rename($from_path, $to_path)) {
      //         error_log("옮기기 성공\n");
      //         $oWebEditorAdminModel->updateTableOfContentPath($item->table_of_content_srl, $to_path);
      //       } else {
      //         error_log("옮기기 실패\n");
      //       }
      //       $this->syncTableOfContentByWeb($item->table_of_content_srl, $to_path, $converted_path_list);
      //     }
          
      //   } else {
      //     $to_path = $to_folder_path.'/'.$item->title;
      //     // $to_path = $to_folder_path.'/'.'ex'.$item->title;
      //     error_log('to_path: '.$to_path);

      //     if($converted_path_list->{$prev_parent_path}) {
      //       $from_path = $prev_parent_path.'/'.$item->title;
      //       error_log('변경전 from_path: '.$from_path);
      //       $from_path = $converted_path_list->{$prev_parent_path}.'/'.$item->title;
      //       // $from_path = $converted_path_list->{$prev_parent_path}.'/'.'ex'.$item->title;

      //       error_log('변경후 from_path: '.$from_path);
      //     } else {
      //       // $from_path = $prev_parent_path.'/'.'ex'.$item->title;
      //       $from_path = $prev_parent_path.'/'.$item->title;
      //       error_log('변경 x from_path: '.$from_path);
      //     }

      //     if($from_path == $to_path) {
      //       error_log("not move");
      //     } else {

      //       // $from_path = str_replace(' ', '\ ', $from_path);
      //       // $to_path = str_replace(' ', '\ ', $from_path);

      //       if(rename($from_path, $to_path)) {
      //         error_log("옮기기 성공\n");
      //         $oWebEditorAdminModel->updateTableOfContentPath($item->table_of_content_srl, $to_path);
      //       } else {
      //         error_log("옮기기 실패\n");
      //       }
      //     }
      //   }
      // }
    }

    public function procWebeditorAdminDeleteTableOfContents() {
      // $oWebEditorAdminModel = getAdminModel('webeditor');
      // $oWebEditorModel = getModel('webeditor');

      // $table_of_content_srls = Context::get('table_of_content_srls');
      // foreach($table_of_content_srls as $table_of_content_srl) {
    
      //   $output = $oWebEditorModel->getWebeditorTableOfContentByTableOfContentSrl($table_of_content_srl);
        
    
      //   @chmod($output->data->path, 0777 );
      //   if($output->data->type == "folder") {
      //     @rmdir($output->data->path);  
      //   } else {
      //     @unlink($output->data->path);
      //   }
      //   $oWebEditorAdminModel->deleteTableOfContent($output->data->table_of_content_srl);
      // }
    }

    public function procWebeditorAdminInsertTableOfContent() {
      // $overLabCount = 1;
      // $parent_table_of_content_srl = Context::get('parent_table_of_content_srl');
      // $location = Context::get('location');
      // $title = Context::get('title');
      // $type = Context::get('type');

      // $source_code_folder_path = sprintf('%ssource_code/', $this->module_path);

      // if($type == 'file') {
      //   // $item_path = $source_code_folder_path.'ex'.$title.'.html';
      //   $item_path = $source_code_folder_path.$title.'.html';
      //   while(file_exists($item_path)) {
      //     $overLabCount = $overLabCount +1;
      //     // $item_path = $source_code_folder_path.'ex'.$title.' '.$overLabCount.'.html';
      //     $item_path = $source_code_folder_path.$title.' '.$overLabCount.'.html';
      //   }
      //   file_put_contents($item_path, "");
      //   $title = basename($item_path);
      //   // $title = substr($title, strlen("ex"));
      // } else {
      //   $item_path = $source_code_folder_path.$title;
      //   while(file_exists($item_path)) {
      //     $overLabCount = $overLabCount +1;
      //     $item_path = $source_code_folder_path.$title.' '.$overLabCount;
      //   }
      //   @mkdir($item_path, 0777);
      //   $title = basename($item_path);
      // }


      // $oWebEditorAdminModel = getAdminModel('webeditor');
      // $oWebEditorModel = getModel('webeditor');

      // $oWebEditorAdminModel->insertTableOfContent($parent_table_of_content_srl, $location, $title, $item_path, $type);
      // $output = $oWebEditorModel->getWebeditorTableOfContentByParentTableOfContentSrlAndLocation($parent_table_of_content_srl, $location);
      
      // $this->add('table_of_content_srl', $output->data->table_of_content_srl);
      // $this->add('title', $output->data->title);
    }

    // ------------------------------------------------------------------------------------------
    
    public function procWebeditorAdminSimpleSetup($moduleSrl, $setupUrl) {
      $moduleSrl = Context::get('module_srl');
      $oModuleModel = getModel('module');

      error_log($moduleSrl);
      $moduleInfo = $oModuleModel->getModuleInfoByModuleSrl($moduleSrl);
      
      
      if (!$moduleInfo || $moduleInfo->module != 'webeditor') {
        return new Object(-1, 'invalid_request');
      }
      
      $args = new stdClass();
      $args->path = Context::get('path');
      
      $oModuleController = getController('module');
      $oModuleController->insertModulePartConfig('webeditor', $moduleSrl, $args);
    }

    public function procWebeditorAdminSyncCodeBySourceCodeFolder() {
      $module_srl = Context::get('module_srl');
      error_log($module_srl);
      
      if (!$module_srl) { return; }
    
      $oModuleModel = getModel('module');
      $config = $oModuleModel->getModulePartConfig('webeditor', $module_srl);    

      $source_code_folder_path = sprintf('%s%s', $this->module_path, $config->path);
      error_log($source_code_folder_path);

      
      $oWebEditorAdminModel = getAdminModel('webeditor');
      $oWebEditorAdminModel->deleteTableOfContents($module_srl);

      $this->syncCodeBySourceCodeFolder($module_srl, "0", $source_code_folder_path);
    }

    function syncCodeBySourceCodeFolder($module_srl, $parent_table_of_content_srl, $source_code_folder_path) {
      $oWebEditorModel = getModel('webeditor');
      $oWebEditorAdminModel = getAdminModel('webeditor');
      $i = 0;
      foreach(glob($source_code_folder_path.'/*', GLOB_ONLYDIR) as $folder_path) {
        $title = basename($folder_path)."장";


        $oWebEditorAdminModel->insertTableOfContent($module_srl, $parent_table_of_content_srl, $i, $title, $folder_path, "folder");
        $output = $oWebEditorModel->getWebeditorTableOfContentByParentTableOfContentSrlAndLocation($module_srl, $parent_table_of_content_srl, $i);
        $this->syncCodeBySourceCodeFolder($module_srl, $output->data->table_of_content_srl, $folder_path);
        $i++;
      }

      foreach(glob($source_code_folder_path.'/*.{*}', GLOB_BRACE) as $file_path) {
        $folder_title = basename($source_code_folder_path);
        $title = basename($file_path);
        // 예제파일 규칙
        if (!preg_match('/.*[.]html$/', $title)) {
          continue;
        }

        $oWebEditorAdminModel->insertTableOfContent($module_srl, $parent_table_of_content_srl, $i, $title, $file_path, "file");

        $code = file_get_contents($file_path); 

        $enc = mb_detect_encoding($code, array("UTF-8", "EUC-KR", "SJIS"));
        if($enc != "UTF-8") {
          $code = iconv($enc, "UTF-8", $code);
        }

        unlink($file_path);
        file_put_contents($file_path, $code);
        $i++;
      }
    }
  }
?>