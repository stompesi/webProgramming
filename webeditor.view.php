<?php
  class webeditorView extends webeditor {



    public function dispWebeditorIndex() {
      Context::addJsFile($this->module_path.'tpl/lib/ace-builds-1.2.3/src/ace.js');
    
    
      $sideMenuHtml = "";
      $this->createSideMenuTableOfContents($sideMenuHtml, "0");

      Context::set('side_menu', $sideMenuHtml);
      
      $this->setTemplateFile('index');
    }

    function createSideMenuTableOfContents(&$sideMenuHtml, $parent_table_of_content_srl) {
      $oWebEditorModel = getModel('webeditor');

      $output = $oWebEditorModel->getTableOfContentsInFolder($parent_table_of_content_srl);

      foreach($output->data as $item) {
        if($item->type =="folder") {
          $sideMenuHtml .= '<li data-table-of-content-srl="'.$item->table_of_content_srl.'" data-parent-table-of-content-srl="'.$parent_table_of_content_srl.'" data-location="'.$item->location.'" data-title="'.$item->title.'">
          <a data-event-click-item rel="folder">
            <span class="directory glyphicon glyphicon-folder-close" aria-hidden="true"></span> 
            <span class="title">'.$item->title.'</span> 
          </a>
          <ul style="display: none;" class="folder">';
          
          $this->createSideMenuTableOfContents($sideMenuHtml, $item->table_of_content_srl);

          $sideMenuHtml .= '</ul><a class="del" href="javascript:void(0)" style="display: none;">x</a></li>';
        } else {
          $sideMenuHtml .= '<li data-table-of-content-srl="'.$item->table_of_content_srl.'" data-parent-table-of-content-srl="'.$parent_table_of_content_srl.'" data-location="'.$item->location.'" data-title="'.$item->title.'">
            <a data-event-click-item rel="file">
              <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
              <span class="title">'.$item->title.'</span>
            </a>
            <a class="del" href="javascript:void(0)" style="display: none;">x</a>
          </li>';
        }
      }
    }    
    /*
    *  @breif 액션 실행 전 먼저 실행되는 메소드
    *  1. 모듈 설정을 가져와서
    *  2. 템플릿에서 사용할 수 있도록 세팅
    *  3. 템플릿 파일을 세팅
    */
    public function init() {
      // 설정 값 가져와 설정 세팅
      $oModuleModel = getModel('module');
      $config = $oModuleModel->getModulePartConfig('webeditor', $this->module_info->module_srl);

      Context::set('config', $config);

      // 템플릿 경로를 스킨 경로로 세팅
      $templatePath = sprintf('%sskins/%s/', $this->module_path, $this->module_info->skin);

      $this->setTemplatePath($templatePath); // PC 스킨 경로로 템플릿 경로 설정

      // 탬플릿 파일명을 세팅
      $templateFile = str_replace('disWebeditor', '', $this->act);
      $this->setTemplateFile($templateFile);

    }



    public function dispWebeditorSourceCode() {      
      $oWebEditorModel = getModel("webeditor");
      $table_of_content_srl = Context::get('table_of_content_srl');
      
      $output = $oWebEditorModel->getWebeditorTableOfContentByTableOfContentSrl($table_of_content_srl);
      error_log("ASDFASDFadsf");
      if($output->data) {
        $file_path = $output->data->path;
        $code = file_get_contents($file_path);

        $this->add("code", $code);
        $this->add("path", $file_path);
      } else {
        $this->add("result", "code 불러오기 실패");
      }
    }
  }
?>