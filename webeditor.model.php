<?php
  class webeditorModel extends webeditor {

    /* executeQuery()
    */
    
    /* executeQueryArray()
    *  쿼리 실행 함수
    *  결과는 Array로 반환 / 결과가 없어도 빈 Array 반환
    *  쿼리 ID는 : 모듈명.쿼리ID 형식으로 지정
    *  ex) 
    *  $args = new stdClass();
    *  $args->page = Context::get('page');
    *  // $args->page가 query.xml의 var="page"랑 매칭
    *  $output = executeQueryArray(webEditor.getSourceCode, $args)
    */
    /*
    *  메뉴 편집의 메뉴 추가에 모듈이 나올 수 있도록 추가
    */
  	public function triggerModuleListInSitemap(&$arr) {
  		array_push($arr, 'webeditor'); // 파라미터로 받은 배열에 모듈 이름을 추가
  	}


    public function getTableOfContentsInFolder($parent_table_of_content_srl) {
      $args = new stdClass();
      $args->parent_table_of_content_srl = $parent_table_of_content_srl;

      $output = executeQueryArray('webeditor.getTableOfContentsInFolder', $args);
      return $output;
    }

    public function getWebeditorTableOfContentByParentTableOfContentSrlAndLocation($parent_table_of_content_srl, $location) {
      $args = new stdClass();
      $args->parent_table_of_content_srl = $parent_table_of_content_srl;
      $args->location = $location;
      $output = executeQuery('webeditor.getTableOfContentByParentTableOfContentSrlAndLocation', $args);      
      return $output;
    }

    public function getWebeditorTableOfContentByTableOfContentSrl($table_of_content_srl) {
      $args = new stdClass();
      $args->table_of_content_srl = $table_of_content_srl;

      $output = executeQuery('webeditor.getTableOfContentByTableOfContentSrl', $args);      
      return $output;
    }

    

    public function getWebeditorSourceCode($position) {
      $args = new stdClass();
      $args->position = $position;
      
      $output = executeQueryArray('webeditor.getSourceCode', $args);
      return $output;
    }
  }
?>