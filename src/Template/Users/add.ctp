<section class="content-header">
    <div class="row">
    <div class="col-xs-12">
        <div class="btn-group pull-right">
<?= $this->Html->link(__('ユーザー一覧'), ['action' => 'index'],['class'=>'btn btn-info btn-sm']) ?>

        </div>
    </div>
</div>
    
    
<h1>
新規ユーザー
<small>パスワードは必須です</small>
</h1>
</section>
    <!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-xs-12">
        <div class="users form">
            <?= $this->Form->create($user, ['role' => 'form']) ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= __('登録情報') ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('username', ['label'=>'ユーザー名','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        echo $this->Form->input('password', ['label'=>'パスワード','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        echo $this->Form->control('role', ['label'=>'権限',
                            'options' => ['user' => 'User', 'admin' => 'Admin']   ]);
                        ?>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('登録'), ['class'=>'btn btn-primary']) ?>
                    <?= $this->Html->link(__('キャンセル'), ['controller' => 'users'], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</section>