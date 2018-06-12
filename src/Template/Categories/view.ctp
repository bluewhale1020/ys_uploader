<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>

   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        カテゴリ&nbsp;&nbsp;&nbsp;
        <span>ID<?= $category->id ?></span>
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
        <li class="active"><?=$this->Html->link(' カテゴリ編集', array('action' => 'edit', $category->id),
                array('class' => 'glyphicon glyphicon-pencil' ))  ?> </li> 
        <li class="separator"></li>
       <li><?=$this->Html->link(' カテゴリ一覧', array('action' => 'index'),
                array('class' => 'glyphicon glyphicon-list'
                        ))  ?></li>  
         <li><?= $this->Form->postLink(__('　カテゴリの削除'), ['action' => 'delete', $category->id],['confirm' => __('本当に {0}　を削除してよろしいですか?', $category->name),'class' => 'glyphicon glyphicon-trash']) ?> </li>

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
              <h3 class="box-title">カテゴリ&nbsp;「<?=$category->name  ?>」 &nbsp;詳細</h3>

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
            <th scope="row"><?= __('カテゴリ名') ?></th>
            <td><?= h($category->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('詳細') ?></th>
            <td><?= h($category->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('規定値') ?></th>
            <td><?php
            if(h($category->is_default) == 1){
                echo "である";
            }else{
                echo "でない";
            }
              ?></td>
        </tr>
       <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($category->id) ?></td>
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
