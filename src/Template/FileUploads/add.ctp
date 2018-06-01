<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FileUpload $fileUpload
 */
?>


<section class="content-header">
    <div class="row">
    <div class="col-xs-12">
        <div class="btn-group pull-right">
<?= $this->Html->link(__('アップロードファイル一覧'), ['action' => 'index'],['class'=>'btn btn-info btn-sm']) ?>

        </div>
    </div>
</div>
    
    
<h1>
新規ファイルアップロード
<small>50MBまでのファイルをアップロードできます</small>
</h1>
</section>
    <!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-xs-12">
        <div class="users form">
<?= $this->Form->create($fileUpload, ['enctype' => 'multipart/form-data']); ?> 
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= __('登録情報') ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
            echo $this->Form->control('file_name',["type"=>"file","label"=>"ファイルを選択"]); 
            echo $this->Form->control('description',["label"=>"内容"]); 
            echo $this->Form->input('password', ['label'=>'パスワード','class' => 'form-control']);
                       
        ?>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('アップロード'), ['class'=>'btn btn-primary']) ?>
                    <?= $this->Html->link(__('キャンセル'), ['action' => 'index'], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>

</div>
</section>