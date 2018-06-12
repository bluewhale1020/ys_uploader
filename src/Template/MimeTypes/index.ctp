<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MimeType[]|\Cake\Collection\CollectionInterface $mimeTypes
 */
?>

<section class="content-header">
<h1>
MimeType一覧
<small>登録されているMimeTypeを一覧表示</small>
</h1>
</section>
<section class="content">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">MimeType一覧表&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo $this->Html->link(' 新規',[
    'action' => 'add'
],
[
    'class' => 'btn btn-sm btn-primary glyphicon glyphicon-plus']

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
  echo $this->Form->input('MimeType名',[
    'empty' => '--'
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->input('拡張子',[
    'options'=> $extArray, 'empty' => '--'
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
                <th scope="col"><?= $this->Paginator->sort('mime_type',"MimeType名") ?></th>
                <th scope="col"><?= $this->Paginator->sort('ext',"拡張子") ?></th>
                <th scope="col"><?= $this->Paginator->sort('ambiguous',"拡張子が非特定") ?></th>
                <th scope="col" class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
            <?php foreach ($mimeTypes as $mimeType): ?>
            <tr>
                <td><?= $this->Number->format($mimeType->id) ?></td>
                <td><?= h($mimeType->mime_type) ?></td>
                <td><?= h($mimeType->ext) ?></td>
                <td><?php
                 if($this->Number->format($mimeType->ambiguous) == 1){
                     echo "✔";
                 }
                 
                  ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $mimeType->id],
                    ['class' => 'btn btn-sm btn-warning glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $mimeType->id],
                    ['class' => 'btn btn-sm btn-success glyphicon glyphicon-pencil']) ?>                    
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $mimeType->id],
                     ['confirm' => __('本当に{0}を削除して宜しいでしょうか?', $mimeType->mime_type),
                    'class' => 'btn btn-sm btn-danger glyphicon glyphicon-remove']) ?> 
                 
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
        
    </div></section>