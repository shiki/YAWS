<?php

namespace YAWS;

/**
 * A Yii application component that provides access to AWS sdk classes. This handles the autoloading
 * setup as well.
 *
 * @author Shiki <shikishiji@gmail.com>
 */
class YAWS extends \CApplicationComponent
{
  /**
   * Absolute path to the AWS SDK files.
   *
   * @var string
   */
  public $sdkLibPath;

  /**
   * Configurations
   *
   * @var array
   */
  public $connections = array(
    's3' => array(
      // Constructor options
      'default' => array(
      )
    )
  );

  /**
   * Load AWS classes if needed.
   */
  public function setupAutoload()
  {
    if (class_exists('CFLoader', false))
      return;

    require_once($this->sdkLibPath . '/sdk.class.php');
    spl_autoload_unregister(array('CFLoader', 'autoloader'));
    \Yii::registerAutoloader(array('CFLoader', 'autoloader'));
  }

  /**
   * Create an instance of {@link \AmazonS3} using the given connection key.
   *
   * @param string $connectionKey An array key that should match a constructor options config
   *        in {@link $connections}.
   *
   * @return \AmazonS3
   */
  public function getS3($connectionKey = 'default')
  {
    $this->setupAutoload();

    $options = $this->connections['s3'][$connectionKey];
    $ret = new \AmazonS3($options);

    return $ret;
  }
}
