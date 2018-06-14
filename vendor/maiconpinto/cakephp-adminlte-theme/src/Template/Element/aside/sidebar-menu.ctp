<?php
use Cake\Core\Configure;

$file = Configure::read('Theme.folder'). DS . 'src' . DS . 'Template' . DS . 'Element' . DS . 'aside' . DS . 'sidebar-menu.ctp';
if (file_exists($file)) {
    ob_start();
    include_once $file;
    echo ob_get_clean();
} else {
?>
<ul class="sidebar-menu">
    <li class="header">メインメニュー</li>
    
   
    <li><a href="<?php echo $this->Url->build('/file-uploads/add'); ?>"><i class="fa fa-circle-o text-primary"></i> <span>新規アップロード</span></a></li>

    <li class="header">カテゴリ選択</li>
    <?php foreach ($categoryData as $key => $oneCategory): ?>
    <li>
        <a href="<?php echo $this->Url->build('/file-uploads/index/'.$oneCategory->id); ?>">
            <i class="fa fa-folder"></i> <span><?=$oneCategory->name  ?></span>
            <span class="pull-right-container">
                <small class="label pull-right bg-blue"><?=$oneCategory->count  ?></small>
            </span>
        </a>
    </li>
    <?php endforeach; ?>
    <li class="header">ドキュメント</li>    
    <li><a href="<?php echo $this->Url->build('/pages/tutorial'); ?>"><i class="fa fa-question"></i> <span>チュートリアル</span></a></li>

    <?php if($authUser['role'] == 'admin'): ?>
    <li class="header"><i class="fas fa-cogs"></i> 管理</li>
 
     <li class="treeview">
        <a href="#">
            <i class="fa fa-folder-open"></i> <span>カテゴリ</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/categories/index'); ?>"><i class="fa fa-circle-o text-aqua"></i> カテゴリ一覧</a></li>
            <li><a href="<?php echo $this->Url->build('/categories/add'); ?>"><i class="fa fa-circle-o text-primary"></i> 新規カテゴリ登録</a></li>
        </ul>
    </li>
    
    <li class="treeview">
        <a href="#">
            <i class="fa fa-users"></i> <span>ユーザー</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/users/index'); ?>"><i class="fa fa-circle-o text-aqua"></i> ユーザー一覧</a></li>
            <li><a href="<?php echo $this->Url->build('/users/add'); ?>"><i class="fa fa-circle-o text-primary"></i> 新規ユーザー登録</a></li>
        </ul>
    </li>    
 
     <li class="treeview">
        <a href="#">
            <i class="fa fa-ellipsis-h"></i> <span>Mime Type</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo $this->Url->build('/mime-types/index'); ?>"><i class="fa fa-circle-o text-aqua"></i> Mime Typeー一覧</a></li>
            <li><a href="<?php echo $this->Url->build('/mime-types/add'); ?>"><i class="fa fa-circle-o text-primary"></i> 新規Mime Type登録</a></li>
        </ul>
    </li>
    
    <li><a href="<?php echo $this->Url->build('/pages/debug'); ?>"><i class="fa fa-bug text-red"></i> Debug</a></li>
<?php endif; ?>

</ul>


<?php } ?>
