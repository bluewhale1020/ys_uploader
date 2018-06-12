<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<section class="content-header">
    <div class="row">
    <div class="col-xs-12">
        <div class="btn-group pull-right">
<?= $this->Html->link(__('カテゴリ一覧'), ['action' => 'index'],['class'=>'btn btn-info btn-sm']) ?>

        </div>
    </div>
</div>
    
    
<h1>
カテゴリ名編集
<small>アップロードファイルが属するカテゴリを編集</small>
</h1>
</section>
    <!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-xs-12">
        <div class="categories form">
            <?= $this->Form->create($category, ['role' => 'form']) ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= __('登録情報') ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('name', ['label'=>'カテゴリ名','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        echo $this->Form->input('description', ['label'=>'詳細','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        echo $this->Form->control('is_default', ['label'=>'規定値で',
                            'options' => ['0' => 'ない','1' => 'ある']   ]);
                        ?>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('更新'), ['class'=>'btn btn-primary']) ?>
                    <?= $this->Html->link(__('キャンセル'), ['controller' => 'categories'], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</section>
