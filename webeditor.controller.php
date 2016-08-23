<?php
  class webeditorController extends webeditor {
    /*
    *  1. 권한 체크하고
    *  2. 데이터 준비
    *  3. document 모듈에 등록하고
    *  4. 글보기 화면으로 이동
    */
    public function procWebeditorWrite() {
      // 권한 체크
      if(!$this->grant->write_document) {
        return new Object(-1, 'msg_not_permitted');
      }

      // 데이터 준비
      $args = new stdClass();
      $args->module_srl = $this->module_srl;
      $args->nick_name = Context::get('nick_name');
      $args->title = Context::get('title');
      $args->content = Context::get('content');

      // document 모듈에 등록
      $oDocumentController = getController('document');
      $output = $oDocumentController->insertDocument('$args');

      if(!$output->toBool()) {
        return $output;
      }

      // 성공시 글 보기 화면으로 이동
      $returnUrl = getNotEncodeUrl('', 'mid', $this->mid, 'document_srl', $output->get('document_srl'));
      $this->setRedirectUrl($returnUrl);
    }
    

    public function procWebeditorSaveSourceCode() {
      $oWebEditorModel = getModel('webeditor');

      $code = Context::get('code');
      $table_of_content_srl = Context::get('table_of_content_srl');
     
      $output = $oWebEditorModel->getWebeditorTableOfContentByTableOfContentSrl($table_of_content_srl);
      error_log( print_R($output,TRUE) );


      $code =mb_convert_encoding($code, 'UTF-8', mb_detect_encoding($data, 'UTF-8, EUC-KR', true));
      // @chmod($output->data->path, 0777);
      // error_log($output->data->path);
      // unlink($output->data->path);
      if(file_put_contents($output->data->path, $code)) {
        error_log("asd"); 
      } else {
        error_log("ccc");
      }

    }
  }
?>