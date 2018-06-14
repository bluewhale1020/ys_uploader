<?php
use Cake\Core\Configure;

$file = Configure::read('Theme.folder') . DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'footer.ctp';

if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.1
    </div>
    <strong>Copyright &copy; 2018 <a href="https://github.com/bluewhale1020/ys_uploader">H.Yasuno</a>.</strong> All rights
    reserved.
</footer>
<?php } ?>
