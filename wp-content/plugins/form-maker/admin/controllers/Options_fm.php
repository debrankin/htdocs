<?php



/**

 * Class FMControllerOptions_fm

 */

class FMControllerOptions_fm extends FMAdminController {



  private $model;

  private $view;



  public function __construct() {

    require_once WDFMInstance(self::PLUGIN)->plugin_dir . "/admin/models/Options_fm.php";

    $this->model = new FMModelOptions_fm();

    require_once WDFMInstance(self::PLUGIN)->plugin_dir . "/admin/views/Options_fm.php";

    $this->view = new FMViewOptions_fm();

  }



  public function execute() {

    $task = WDW_FM_Library(self::PLUGIN)->get('task');

    $id = (int) WDW_FM_Library(self::PLUGIN)->get('current_id', 0);

    if ( method_exists($this, $task) ) {

      check_admin_referer(WDFMInstance(self::PLUGIN)->nonce, WDFMInstance(self::PLUGIN)->nonce);

      $this->$task($id);

    }

    else {

      $this->display();

    }

  }



  public function display() {

    $fm_settings = get_option(WDFMInstance(self::PLUGIN)->is_free == 2 ? 'fmc_settings' : 'fm_settings');

    $this->view->display($fm_settings);

  }



  public function save() {

    $message = $this->model->save_db();

    $page = WDW_FM_Library(self::PLUGIN)->get('page');

    WDW_FM_Library(self::PLUGIN)->fm_redirect(add_query_arg(array(

                                                'page' => $page,

                                                'task' => 'display',

                                                'message' => $message,

                                              ), admin_url('admin.php')));

  }

}

