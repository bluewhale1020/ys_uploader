<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MimeType $mimeType
 */
?>

   <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        MimeType&nbsp;&nbsp;&nbsp;
        <span>ID<?= $mimeType->id ?></span>
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
        <li class="active"><?=$this->Html->link(' MimeType編集', array('action' => 'edit', $mimeType->id),
                array('class' => 'glyphicon glyphicon-pencil' ))  ?> </li> 
        <li class="separator"></li>
       <li><?=$this->Html->link(' MimeType一覧', array('action' => 'index'),
                array('class' => 'glyphicon glyphicon-list'
                        ))  ?></li>  
         <li><?= $this->Form->postLink(__('　MimeTypeの削除'), ['action' => 'delete', $mimeType->id],['confirm' => __('本当に {0}　を削除してよろしいですか?', $mimeType->mime_type),'class' => 'glyphicon glyphicon-trash']) ?> </li>

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
              <h3 class="box-title">MimeType&nbsp;「<?=$mimeType->mime_type  ?>」 &nbsp;詳細</h3>

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
            <th scope="row"><?= __('MimeType名') ?></th>
            <td><?= h($mimeType->mime_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('拡張子') ?></th>
            <td><?= h($mimeType->ext) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('拡張子が') ?></th>
            <td><?php
            if(h($mimeType->ambiguous) == 1){
                echo "非特定";
            }else{
                echo "特定";
            }
              ?></td>
        </tr>
       <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($mimeType->id) ?></td>
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
