<section class="content-header">
<h1>
ユーザー一覧
<small>登録ユーザーの一覧表示</small>
</h1>
</section>
<section class="content">
 
    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">ユーザー一覧表&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Html->link(' 新規ユーザー',[
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
  echo $this->Form->input('ユーザー名',[
    'empty' => '--'
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
                <th scope="col"><?= $this->Paginator->sort('username',"ユーザー名") ?></th>
                <th scope="col"><?= $this->Paginator->sort('role',"権限") ?></th>
                <th scope="col"><?= $this->Paginator->sort('created',"作成日") ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified',"最終更新日") ?></th>
                <th scope="col" class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $this->Number->format($user->id) ?></td>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->role) ?></td>
                <td><?= h($user->created) ?></td>
                <td><?= h($user->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $user->id],
                    ['class' => 'btn btn-warning glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $user->id],
                    ['class' => 'btn btn-success glyphicon glyphicon-pencil']) ?>                    
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $user->id],
                     ['confirm' => __('本当に{0}を削除して宜しいでしょうか?', $user->username),
                    'class' => 'btn btn-danger glyphicon glyphicon-remove']) ?>                    
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

