<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FileUpload[]|\Cake\Collection\CollectionInterface $fileUploads
 */
?>
<?php echo $this->Html->script('jquery-3.3.1.min'); ?>
<?php echo $this->Html->script('jqgrid-export'); ?>

<script language="JavaScript"><!--

var file_id = null;

$(document).ready(function(){
    'use strict';
    // JavaScript で表示
    // $('#download_link').on('click', function() {
      // $("#mode").val("download");
      // $("#del_btn").text("ダウンロード");
      // $('#passwordModal').modal();
//       
    // });
    $('.delete_link').on('click', function() {
        if(confirm('本当に # '+file_id+'のファイルを削除してよろしいですか?')){
            
            if($(this).attr("lock_status") == 1){
                $("#mode").val("delete");
                $("#del_btn").text("削除");
               $('#passwordModal').modal();                
            }else{
                  var action = "delete";
                  postActionLink(action,file_id,$("#password").val());                
            }
            
 
        }
      
    });    
    // ダイアログ表示前にJavaScriptで操作する
    $('#passwordModal').on('show.bs.modal', function(event) {
        $("#password").val("");
     // var recipient = button.data('whatever');
      // var modal = $(this);
      // modal.find('.modal-body .recipient').text(recipient);
      //modal.find('.modal-body input').val(recipient);
    });
    // ダイアログ表示直後にフォーカスを設定する
    $('#passwordModal').on('shown.bs.modal', function(event) {
      $('#password').focus();
    });
    $('#passwordModal').on('click', '.modal-footer .btn-primary', function() {
      $('#passwordModal').modal('hide');
      var action = $("#mode").val();
      postActionLink(action,file_id,$("#password").val());
    });
    
    
    });
    
    
    function postActionLink(action,id,pass){
        
            //受診基本／詳細データをサーバーへポストする 
        var Url = "/ys_uploader/file-uploads/" + action + "/" + id ;
        //urlはプロジェクト名/コントローラー名アンダーライン型/アクション名小文字
    jqueryPost(Url, "Post", {'pass':pass});
        
    }
    
--></script>


<section class="content-header">
<h1>
アップロードファイル一覧
<small>アップロードされているファイルを一覧表示</small>
</h1>
</section>
<section class="content">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">ファイル一覧表&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Html->link(' 新規アップロード',[
    'action' => 'add'
],
[
    'class' => 'btn btn-primary glyphicon glyphicon-plus']

);
?>
        
    </h3>
    <div class="box-tools pull-right">
      <!-- Buttons, labels, and many other things can be placed here! -->
      <!-- Here is a label for example -->
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>

    </div><!-- /.box-tools -->
  </div><!-- /.box-header -->
  <div class="box-body">
  
  <div class="col-md-9 pull-right">   
 <div class="box box-solid text-right bg-gray">
  <div class="box-body">
 <div >
   <?php
    echo $this->Form->create(null,[
    'url'=>['action' => 'index']
    ,'class' => 'form-inline'
  ]); ?>
  
  <fieldset>

  <?php
  echo $this->Form->input('ファイル名',[
    'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->input('ファイル種類',[
    'options'=> $mimetypes, 'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->button('検索',['class' => 'btn-primary btn-sm']);
  ?>
  </fieldset>


  <?php echo $this->Form->end(); ?>  
 
</div> 
  </div><!-- /.box-body -->
</div><!-- /.box -->
</div> 
   
  <div class="uploadfile-table">
  <table class="table table-bordered table-hover table-striped">
      <thead>
             <tr class="bg-info">
                <th scope="col"><?= $this->Paginator->sort('id',"ID") ?></th>
                <th scope="col"><?= $this->Paginator->sort('password',"パス") ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_name',"ファイル名") ?></th>
                <th scope="col"><?= $this->Paginator->sort('mime_type',"ファイル種類") ?></th>
                <th scope="col"><?= $this->Paginator->sort('file_size',"サイズ") ?></th>
                <th scope="col"><?= $this->Paginator->sort('description',"内容") ?></th>                
                <th scope="col"><?= $this->Paginator->sort('created',"作成日") ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified',"最終更新日") ?></th>
                <th scope="col" class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
            <?php foreach ($fileUploads as $fileUpload): ?>
            <tr>
                <td><?= $this->Number->format($fileUpload->id) ?></td>
                <td><?php
                 if(!empty($fileUpload->password)){
                  echo '<i class="fa fa-lock text-yellow"></i>';
                     $locked = 1;   
                 }else{
                     $locked = 0;
                 }
                 
                  ?></td>
                <td><?= h($fileUpload->file_name) ?></td>
                <td><?= h($fileUpload->mime_type) ?></td>
                <td><?= h($fileUpload->file_size) ?></td>
                <td><?= h($fileUpload->description) ?></td>                
                <td><?= h($fileUpload->created) ?></td>
                <td><?= h($fileUpload->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $fileUpload->id],
                    ['class' => 'btn btn-warning glyphicon glyphicon-info-sign']) ?>

<?=$this->Html->link(' ファイルの削除', array('action' => 'delete'),
                array('lock_status'=>$locked,'class' => 'delete_link btn btn-danger glyphicon glyphicon-remove','onclick'=>'file_id = '.$fileUpload->id.';return false;'))  ?>                
                   
                </td>
            </tr>
            <?php endforeach; ?>       
          
      </tbody>      
      
  </table>
     <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('最初')) ?>
            <?= $this->Paginator->prev('< ' . __('前')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次') . ' >') ?>
            <?= $this->Paginator->last(__('最後') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>     
      
  </div>
    
    
    
  </div><!-- /.box-body -->
  <div class="box-footer">
    
  </div><!-- box-footer -->
</div><!-- /.box -->            
            
            
            
        </div>       
        
    </div>

</section>
<!-- モーダルダイアローグ -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="passwordModalLabel">ファイルに設定したパスワードを入力</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="password" class="control-label">パスワード</label>
            <input type="password" class="form-control" id="password">
          </div>
          <input type="hidden" class="form-control" id="mode" value="">
          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
        <button type="button" class="btn btn-primary" id="del_btn">削除</button>
      </div>
    </div>
  </div>
</div>
