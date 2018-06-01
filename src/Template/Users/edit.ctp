<section class="content-header">
    <div class="row">
    <div class="col-xs-12">
        <div class="btn-group pull-right">
<?php //echo $this->Html->link(__('ユーザー一覧'), ['action' => 'index'],['class'=>'btn btn-info btn-sm']); ?>

        </div>
    </div>
</div>
    
    
<h1>
ユーザー情報編集
<small>パスワードは必須です</small>
</h1>
</section>

    <!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-xs-12">
        <div class="users form">
            <?= $this->Form->create($user, ['role' => 'form']) ?>
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= __('更新内容') ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('username', ['label'=>'ユーザー名','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        echo $this->Form->input('password', ['label'=>'パスワード','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        if($authUser['role'] == 'admin'){
                            echo $this->Form->control('role', ['label'=>'権限',
                            'options' => ['user' => 'User', 'admin' => 'Admin']   ]);                        
                            
                        }
                        ?>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('更新'), ['class'=>'btn btn-success']) ?>
                    <?= $this->Html->link(__('キャンセル'), ['action' => 'view',$user->id], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</section>