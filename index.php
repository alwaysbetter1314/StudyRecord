<?php
  require_once 'tools/Parsedown.php';
  // Header
  function getDirAndFileList(){
    // 获取当前文件的上级目录
    $con = dirname('markdown/README.md');
    return scandir($con);
  }
  echo "<nav style=\"overflow:scroll;\">";
  foreach(getDirAndFileList() as $tmp){
    echo "<button onclick=\"change('$tmp')\">$tmp</button>";
  }
  echo "</nav>";
  // Content
  // load file
  $parser = new Parsedown();
  function file2markdown($file){
    $home = 'markdown/';
    global $parser;
    $text = file_get_contents($home.$file);
    return $parser->text($text);
  }
  $file = 'README.md';
  $html = file2markdown($file);

  echo "<div width=\"80px\" id=\"content\">$html</div>";
  // 获取目录中所有文件
  $name = 'END';
  echo "<button>$name</button>";
  echo "<script>";
  echo "var dict = {};\n";
  foreach(getDirAndFileList() as $tmp){
    if ($tmp=="." || $tmp =="..") continue;
    else {
      $con = file2markdown($tmp);
      echo "dict['$tmp']=`$con`;";
    }
  }
  echo "</script>";
  print <<<EOF
  <script>
  console.log(dict);
    function change(fuck){
    document.getElementById("content").innerHTML=dict[fuck];
    }
  </script>
EOF;
?>
