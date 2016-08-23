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
      // 1. 모듈 정보, 모듈 설정 가져오기
      $oModuleModel = getModel('module');
      $moduleInfo = $oModuleModel->getModuleInfoByModuleSrl($moduleSrl); // 모듈 정보가져오기
      $config = $oModuleModel->getModulePartConfig('webeditor', $moduleSrl); // 모듈 설정 가져오기

      // 2. 템플릿에서 사용할 수 있도록 세팅
      Context::set('module_info', $moduleInfo); // 템플릿 변수를 세팅하는 메소드(변수이름, 값)
      Context::set('config', $config);

      // 3. 템플릿 컴파일한 결과 반환 
      $oTemplate = TemplateHandler::getInstance(); // 템플릿을 다루기 위한 클레스
      $html = $oTemplate->compile($this->module_path . 'tpl/', 'simple_setup'); // 특정 템플릿을 컴파일한 결과를 반환

      return $html;
    }

    public function deleteTableOfContent($table_of_content_srl) {
      $args = new stdClass();
      $args->table_of_content_srl = $table_of_content_srl;
      $output = executeQuery('webeditor.deleteTableOfContent', $args);
      // 
    }

    public function deleteTableOfContentsInFolder($parent_table_of_content_srl) {
      $oWebEditorModel = getModel('webeditor');

      $args = new stdClass();
      $args->parent_table_of_content_srl = $parent_table_of_content_srl;
      

      $output = $oWebEditorModel->getTableOfContentsInFolder($parent_table_of_content_srl);
      error_log("output - 1");
      error_log(print_R($output,TRUE));

      foreach($output->data as $item) {
        if($item->type =="folder") {
          $this->deleteTableOfContentsInFolder($item->table_of_content_srl);

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

   

    public function insertTableOfContent($parent_table_of_content_srl, $location, $title, $path, $type) {
      // error_log('insert width parent_table_of_content_srl: '.$parent_table_of_content_srl.' order: '.$location);      
      $oTableOfContent = new stdClass();
      $oTableOfContent->location = $location;
      $oTableOfContent->parent_table_of_content_srl = $parent_table_of_content_srl;

      $oTableOfContent->module_srl = Context::get('module_srl');
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