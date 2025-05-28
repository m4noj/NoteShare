<?php
// Dynamic breadcrumbs based on URL path
function generateBreadcrumbs() {
  $path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
  $parts = explode('/', trim($path, '/'));
  
  echo '<nav aria-label="breadcrumb">';
  echo '<ol class="breadcrumb">';
  echo '<li class="breadcrumb-item"><a href="/home.php">Home</a></li>';

  $crumbPath = '';
  foreach ($parts as $part) {
    if(empty($part)) continue;
    $crumbPath .= '/' . $part;
    $crumbName = ucfirst(str_replace('-', ' ', $part));
    if ($part === end($parts)) {
      echo "<li class='breadcrumb-item active' aria-current='page'>$crumbName</li>";
    } else {
      echo "<li class='breadcrumb-item'><a href='$crumbPath'>$crumbName</a></li>";
    }
  }

  echo '</ol>';
  echo '</nav>';
}
generateBreadcrumbs();


?>