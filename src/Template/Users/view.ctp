   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        ユーザープロファイル&nbsp;&nbsp;&nbsp;
        <span>ID<?= $user->id ?></span>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-4">

          <div class="box box-solid box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">メニュー</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <ul class="nav nav-pills nav-stacked">
        <li class="active"><?=$this->Html->link(' ユーザー編集', array('action' => 'edit', $user->id),
                array('class' => 'glyphicon glyphicon-pencil' ))  ?> </li> 
<?php if($authUser['role'] == 'admin'): ?>                 
        <li class="separator"></li>

       <li><?=$this->Html->link(' ユーザー一覧', array('action' => 'index'),
                array('class' => 'glyphicon glyphicon-list'
                        ))  ?></li>  
         <li><?= $this->Form->postLink(__('　ユーザーの削除'), ['action' => 'delete', $user->id],['confirm' => __('本当に {0}　を削除してよろしいですか?', $user->username),'class' => 'glyphicon glyphicon-trash']) ?> </li>
<?php endif; ?>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->

        </div>
        <!-- /.col -->
        <div class="col-md-8">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$user->username  ?> 詳細</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <div class="table-responsive">
      
    <table class="table vertical-table table-bordered table-hover table-striped">
            <tr class="bg-orange-active">
            <th>項目名</th>
            <th>データ</th>
            </tr>        
        <tr>
            <th scope="row"><?= __('ユーザー名') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('パスワード') ?></th>
            <td><?= h("****") ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('権限') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
       <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('作成日') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('最終更新日') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>                
                
              </div>
              <!-- /.responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->