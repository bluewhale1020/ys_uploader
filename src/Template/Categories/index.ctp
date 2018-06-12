<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>

<section class="content-header">
<h1>
カテゴリ一覧
<small>登録されているカテゴリを一覧表示</small>
</h1>
</section>
<section class="content">
 


    <div class="row">
        <div class="col-md-12">

<div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">カテゴリ一覧表&nbsp;&nbsp;&nbsp;&nbsp;
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
  echo $this->Form->input('カテゴリ名',[
    'empty' => '--','options'=> $categoryArray
  ]);
  ?>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
  echo $this->Form->input('規定値',[
    'options'=> [1=>"はい",2=>"いいえ"], 'empty' => '--'
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
                <th scope="col"><?= $this->Paginator->sort('name',"カテゴリ名") ?></th>
                <th scope="col"><?= $this->Paginator->sort('description',"詳細") ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_default',"規定値") ?></th>
                <th scope="col" class="actions"><?= __('操作') ?></th>
            </tr>         
      </thead>
      <tbody>
            <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $this->Number->format($category->id) ?></td>
                <td><?= h($category->name) ?></td>
                <td><?= h($category->description) ?></td>
                <td><?php
                 if($this->Number->format($category->is_default) == 1){
                     echo "✔";
                 }
                 
                  ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('　閲覧'), ['action' => 'view', $category->id],
                    ['class' => 'btn btn-sm btn-warning glyphicon glyphicon-info-sign']) ?>
                    <?= $this->Html->link(__('　編集'), ['action' => 'edit', $category->id],
                    ['class' => 'btn btn-sm btn-success glyphicon glyphicon-pencil']) ?>                    
                    <?= $this->Form->postLink(__('　削除'), ['action' => 'delete', $category->id],
                     ['confirm' => __('本当に{0}を削除して宜しいでしょうか?', $category->name),
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
