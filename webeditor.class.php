<?php
  class webeditor extends ModuleObject { // XE의 모든 모듈은 ModuleObject를 상속 받아야 함
    
    var $skin = "default";

    /*
    * 모듈 트리거 목록
    * 트리거 등록을 위한 변수 
    */ 
    private $triggers = array(
      array(
        'name' => 'menu.getModuleListInSitemap',    // 사용할 트러거 이름
        'module' => 'webeditor',                    // 트리거 발생시 실행할 모듈 이름
        'type' => 'model',                          // 메소드가 포함된 클래스 타입
        'func' => 'triggerModuleListInSitemap',     // 트리거 발생 시 실행할 메소드
        'position' => 'after'                       // 트리거 이전 / 이후 실행인지 
      )
    );

    /* 
    *  모듈 설치 시 호출됨
    *  모듈이 modules 폴더에 있는 상태로 XE 설치 시
    *  쉬운 설치 설치 시
    */
    public function moduleInstall() {
      $oModuleController = getController('module'); // 모듈과 관련된 조작 메소드를 가짐

      foreach($this->triggers as $trigger) {
        // 트리거를 등록하는 메소드
        $oModuleController->insertTrigger($trigger['name'], $trigger['module'], $trigger['type'], $trigger['func'], $trigger['position']);
      }

      return new Object();
    }

    /*
    *  업데이트 체크를 위해 호출 됨.
    *  true를 반환하면 업데이트가 필요한 것으로 표시 된다.
    */
    public function checkUpdate() {
      $oModuleModel = getModel('module');

      foreach($this->triggers as $trigger) {
        // 트리거를 정보를 받는 메소드
        $res = $oModuleModel->getTrigger($trigger['name'], $trigger['module'], $trigger['type'], $trigger['func'], $trigger['position']);

        if(!$res) { // 트리거가 없으면 없데이트가 필요하다는 것을 리턴
          return true;
        }
      }

      return false;
    }

    /*
    *  모듈 업데이트 시 호출 됨
    */
    public function moduleUpdate() {
      $oModuleModel = getModel('module');
      $oModuleController = getController('module');


      foreach($this->triggers as $trigger) {
        // 트리거를 정보를 받는 메소드
        $res = $oModuleModel->getTrigger($trigger['name'], $trigger['module'], $trigger['type'], $trigger['func'], $trigger['position']);

        if(!$res) { 
          // 트리거를 등록하는 메소드
          $oModuleController->insertTrigger($trigger['name'], $trigger['module'], $trigger['type'], $trigger['func'], $trigger['position']);
        }
      }
      return new Object();
    }

    /* 
    *  쉬운 설치에 올라가 있을때만 삭제가 가능
    *  쉬운설치를 통한 모듈 삭제 시 호출 됨
    */
    public function moduleUninstall() {

      $oModuleController = getController('module');

      $oModuleController->deleteTrigger($trigger['name'], $trigger['module'], $trigger['type'], $trigger['func'], $trigger['position']);

      return new Object();
    }
  }
?>