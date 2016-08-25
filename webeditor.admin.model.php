<?php
  class webeditorAdminModel extends webeditor {

    /*
    *  1. 모듈정보, 모듈 설정 가져오기
    *  2. 템플릿에서 사용할 수 있도록 세팅
    *  3. 템플릿 컴파일한 결과 반환 
    *  - Tip. 템플릿: 출력 내용을 미리 준비해 두고 필요한 부분만 대치하여 사용하는 개념
    *
    *  $moduleSrl: 모듈 번호
    *  $setupUrl: 상세서정 URL
    */
    public function getWebeditorAdminSimpleSetup($moduleSrl, $setupUrl) {

      if (!$moduleSrl) { return; }
      
      $oModuleModel = getModel('module');
      $moduleInfo = $oModuleModel->getModuleInfoByModuleSrl($moduleSrl);
      if (!$moduleInfo) { return; }
      
      Context::set('module_info', $moduleInfo);
      
      $config = $oModuleModel->getModulePartConfig('webeditor', $moduleSrl);    
      Context::set('config', $config);
      
      $oTemplate = TemplateHandler::getInstance();
      $html = $oTemplate->compile($this->module_path . 'tpl/', 'simple_setup');
      
      error_log($moduleInfo->module_srl);
      return $html;
    }

    public function deleteTableOfContent($table_of_content_srl) {
      $args = new stdClass();
      $args->table_of_content_srl = $table_of_content_srl;
      $output = executeQuery('webeditor.deleteTableOfContent', $args);
      // 
    }

    public function deleteTableOfContents($module_srl) {
      $args = new stdClass();
      $args->module_srl = $module_srl;

      executeQuery('webeditor.deleteTableOfContents', $args);
    }

    public function deleteTableOfContentsInFolder($module_srl, $parent_table_of_content_srl) {
      $oWebEditorModel = getModel('webeditor');

      $args = new stdClass();
      $args->parent_table_of_content_srl = $parent_table_of_content_srl;
      $args->module_srl = $module_srl;

      $output = $oWebEditorModel->getTableOfContentsInFolder($module_srl, $parent_table_of_content_srl);
      error_log("output - 1");
      error_log(print_R($output,TRUE));

      foreach($output->data as $item) {
        if($item->type =="folder") {
          $this->deleteTableOfContentsInFolder($module_srl, $item->table_of_content_srl);

          $this->deleteTableOfContent($item->table_of_content_srl);
        } 
      }
      error_log(print_R($args,TRUE));
      
      $output = executeQuery('webeditor.deleteTableOfContentsInFolder', $args);
      error_log("output - 3");
      error_log(print_R($output,TRUE));
    }
     public function updateTableOfContentPath($table_of_content_srl, $path) {

      // 


      $args = new stdClass();
      $args->table_of_content_srl = $table_of_content_srl;
      $args->path = $path;
      
  
      

      $output = executeQuery('webeditor.updateTableOfContentPath', $args);

    }

    public function updateTableOfContent($table_of_content) {
      $args = new stdClass();
      $args->table_of_content_srl = $table_of_content['table_of_content_srl'];
      $args->location = $table_of_content['location'];
      $args->parent_table_of_content_srl = $table_of_content['parent_table_of_content_srl'];
      $args->title = $table_of_content['title'];
      
      $output = executeQuery('webeditor.updateTableOfContent', $args);
    }

   

    public function insertTableOfContent($module_srl, $parent_table_of_content_srl, $location, $title, $path, $type) {
      // error_log('insert width parent_table_of_content_srl: '.$parent_table_of_content_srl.' order: '.$location);      
      $oTableOfContent = new stdClass();
      $oTableOfContent->location = $location;
      $oTableOfContent->parent_table_of_content_srl = $parent_table_of_content_srl;
      $oTableOfContent->module_srl = $module_srl;
      $oTableOfContent->title = $title;
      $oTableOfContent->path = $path;
      $oTableOfContent->type = $type;
      $output = executeQuery('webeditor.insertTableOfContent', $oTableOfContent);
      // error_log($output->variables->_query);
    } 

    public function test() {
      error_log("message");
    }
  }
?>