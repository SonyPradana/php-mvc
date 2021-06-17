<?php

use System\Apps\Command;
use System\Database\{MyPDO, MyQuery};

class MakeCommand extends Command
{

  public static array $command = array(
    [
      "cmd"       => "make",
      "mode"      => "start",
      "class"     => MakeCommand::class,
      "fn"        => "switcher",
    ],
  );

  public function printHelp()
  {
    return array(
      'option' => array(
        "\n\t" . $this->textGreen("make") . ":controller [controller_name]\t\tgenerate new controller and view",
        "\n\t" . $this->textGreen("make") . ":view [view_name]\t\t\t\tgenerate new view",
        "\n\t" . $this->textGreen("make") . ":service [services_name]\t\t\tgenerate new service",
        "\n\t" . $this->textGreen("make") . ":model [model_name] " . $this->textDim("[argument]") . "\t\tgenerate new model",
        "\n\t" . $this->textGreen("make") . ":models [models_name] " . $this->textDim("[argument]") . "\t\tgenerate new models",
      ),
      'argument' => array(
        "\n\t" . $this->textDim("--table-name=[table_name]") . "\tget table column when creating model/models",
      )
    );

  }

  public function switcher()
  {
    // get category command
    $makeAction = explode(':', $this->CMD);

    // get naming class
    if ($this->OPTION[0] == '') {
      echo "\tArgument name cant be null";
      echo "\n\t>>\t" . $this->textGreen("php") . " cli " . $this->textGreen("make:") . $makeAction[1] . $this->textRed(" not_null");
      exit;
    }

    // stopwatch
    $watch_start = microtime(true);

    // find router
    switch ($makeAction[1]) {
      case 'controller':
        $this->make_controller();
        $this->make_view();
        break;

      case 'view':
        $this->make_view();
        break;

      case 'service':
        $this->make_servises();
        break;

      case 'model':
        $this->make_model();
        break;

      case 'models':
        $this->make_models();
        break;

      default:
        echo $this->textRed("\nArgumnet not register");
        break;
    }

    // end stopwatch
    $watch_end = round(microtime(true) - $watch_start, 3) * 1000;
    echo "\nDone in " . $this->textYellow($watch_end ."ms\n");
  }

  public function make_controller()
  {
    echo $this->textYellow("Making controller file...");
    echo $this->textDim("\n...\n");

    // main code
    $success = $this->makeTemplate($this->OPTION[0], array (
      'template_location' => '/app/core/template/controller',
      'save_location' => APP_PATH['controllers'],
      'pattern' => '__controller__',
      'surfix' => 'Controller.php'
    ));

    // the result
    if ($success) {
      echo $this->textGreen("\nFinish created controller\n");
    } else {
      echo $this->textRed("\nFailed Create controller\n");
    }
  }

  public function make_view()
  {
    echo $this->textYellow("Making view file...");
    echo $this->textDim("\n...\n");

    // main code
    $success = $this->makeTemplate($this->OPTION[0], array (
      'template_location' => '/app/core/template/view',
      'save_location'     => APP_PATH['view'],
      'pattern'           => '__view__',
      'surfix'            => '.template.php'
    ));

    // the result
    if ($success) {
      echo $this->textGreen("\nFinish created view file\n");
    } else {
      echo $this->textRed("\nFailed Create view file\n");
    }
  }

  public function make_servises()
  {
    echo $this->textYellow("Making service file...");
    echo $this->textDim("\n...\n");

    // main code
    $success = $this->makeTemplate($this->OPTION[0], array(
      'template_location' => '/app/core/template/service',
      'save_location'     => APP_PATH['services'],
      'pattern'           => '__service__',
      'surfix'            => 'Service.php'
    ));

    // the result
    if ($success) {
      echo $this->textGreen("\nFinish created services file");
    }else {
      echo $this->textRed("\nFailed Create services file");
    }
  }

  public function make_model()
  {
    echo $this->textYellow("Making model file...");
    echo $this->textDim("\n...\n");

    // main code
    $success = $this->makeTemplate($this->OPTION[0],array(
      'template_location' => '/app/core/template/model',
      'save_location'     => APP_PATH['model'],
      'pattern'           => '__model__',
      'surfix'            => '.php'
    ), $this->OPTION[0] . '/');

    // fill table name
    if (substr($this->OPTION[1], 0, 12) == '--table-name') {
      $table_name = explode('=', $this->OPTION[1])[1];
      $this->FillModelDatabase(
        APP_FULLPATH['model'] . $this->OPTION[0] . '/' . $this->OPTION[0] . ".php",
        $table_name);
    }

    // the result
    if ($success) {
      echo $this->textGreen("\nFinish created model file");
    } else {
      echo $this->textRed("\nFailed Create model file");
    }
  }

  public function make_models()
  {
    echo $this->textYellow("Making models file...");
    echo $this->textDim("\n...\n");

    // main code
    $success = $this->makeTemplate($this->OPTION[0], array(
      'template_location' => '/app/core/template/models',
      'save_location'     => APP_PATH['model'],
      'pattern'           => '__models__',
      'surfix'            => 's.php'
    ), $this->OPTION[0] . '/');

    // fill table name
    if (substr($this->OPTION[1], 0, 12) == '--table-name') {
      $table_name = explode('=', $this->OPTION[1])[1];
      $this->FillModelsDatabase(
        APP_FULLPATH['model'] . $this->OPTION[0] . '/' . $this->OPTION[0] . "s.php",
        $table_name);
    }

    // the result
    if ($success) {
      echo $this->textGreen("\nFinish created models file");
    } else {
      echo $this->textRed("\nFailed Create models file");
    }
  }

  /**
   * Replece template to new class/resoure
   *
   * @param string $argument Name of Class/file
   * @param array $make_option Configuration to replace template
   * @param string $folder Create folder for save location
   * @return boolean True if templete success copie
  */
  private function makeTemplate(string $argument, array $make_option, string $folder = ''): bool
  {
    $folder = ucfirst($folder);
    if (file_exists(BASEURL . $make_option['save_location'] . $folder . $argument . $make_option['surfix'])) {
      echo $this->textDim("file alredy exis");
      return false;

    } elseif (! file_exists(BASEURL . $make_option['save_location'] . $folder)) {
      mkdir(BASEURL . $make_option['save_location'] . $folder);
    }

    $get_template = file_get_contents(BASEURL . $make_option['template_location']);
    // frist replace ucfrist pattern by at @
    $get_template = str_replace("@" . $make_option['pattern'], ucfirst($argument),  $get_template);
    // replace patternt
    $get_template = str_replace($make_option['pattern'], $argument,  $get_template);
    // saving
    $isCopied = file_put_contents(BASEURL . $make_option['save_location'] . $folder . $argument . $make_option['surfix'], $get_template);

    return $isCopied === false ? false : true;
  }

  /**
   * Fill template with property
   * base on databe table
   *
   * @param string $model_location File location (model)
   * @param string $table_name Tabel name to sync with model
   * @return boolean True if templete success copie
  */
  private function FillModelDatabase(string $model_location, string $table_name): bool
  {
    $table_column = MyQuery::from("COLUMNS", MyPDO::conn("INFORMATION_SCHEMA"))
      ->select()
      ->equal("TABLE_SCHEMA", DB_NAME)
      ->equal("TABLE_NAME", $table_name)
      ->all() ?? [];

    $column_template = '';
    $getter_template = '';
    $setter_template = '';

    foreach ($table_column as $column) {
      if ($column['COLUMN_NAME'] != 'id') {
        $column_template .= "'" . $column['COLUMN_NAME'] . "' => null,\n\t\t\t";
        $getter_template .= $this->TemplateGetterModel($column['COLUMN_NAME']);
        $setter_template .= $this->TemplateSetterModel($column['COLUMN_NAME']);
      }

    }

    $getContent = file_get_contents($model_location);
    // replece table name
    $getContent = str_replace('__table__', $table_name, $getContent);
    // replace teble column
    $getContent = str_replace('__column__', $column_template, $getContent);
    // replece getter and setter
    $getContent = str_replace('__getter__', $getter_template, $getContent);
    $getContent = str_replace('__setter__', $setter_template, $getContent);

    $isCopied   = file_put_contents($model_location, $getContent);

    return $isCopied === false ? false : true;
  }

  /**
   * Fill template with property
   * base on databe table
   *
   * @param string $model_location File location (models)
   * @param string $table_name Tabel name to sync with models
   * @return boolean True if templete success copie
  */
  private function FillModelsDatabase(string $model_location, string $table_name)
  {
    $getContent = file_get_contents($model_location);
    $getContent = str_replace('__table__', $table_name, $getContent);
    $isCopied   = file_put_contents($model_location, $getContent);

    return $isCopied === false ? false : true;
  }

  // helper

  /**
   * Helper for make model
   */
  private function TemplateGetterModel(string $column_name): string
  {
    return
      "\n\t"    . "public function $column_name()" .
      "\n\t"    . "{" .
      "\n\t\t"  . "return " . "$" . "this->COLUMNS['$column_name'];" .
      "\n\t"    . "}" .
      "\n";
  }

  /**
   * Helper for make model
   */
  private function TemplateSetterModel(string $column_name): string
  {
    $functionName = ucfirst($column_name);
    return
      "\n\t"      . "public function set$functionName(int " . "$" . "val)" .
      "\n\t"      . "{" .
      "\n\t\t"    . "$" . "this->COLUMNS['$column_name'] = " . "$" . "val;" .
      "\n\t\t"    . "return " . "$" . "this;" .
      "\n\t"      . "}" .
      "\n";
  }
}
