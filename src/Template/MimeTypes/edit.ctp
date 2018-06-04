<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MimeType $mimeType
 */
?>
<?php echo $this->Html->script('jquery-3.3.1.min'); ?>
<script language="JavaScript"><!--

$(document).ready(function(){
    'use strict';

    $('#ext').on('blur', function() {
        if($(this).val() == ''){
            $("#ambiguous").val(1);
         }else{
            $("#ambiguous").val(0);
        }
      
    });    
    
    
    });

    
--></script>

<section class="content-header">
    <div class="row">
    <div class="col-xs-12">
        <div class="btn-group pull-right">
<?= $this->Html->link(__('MimeType一覧'), ['action' => 'index'],['class'=>'btn btn-info btn-sm']) ?>

        </div>
    </div>
</div>
    
    
<h1>
MimeType編集
<small>拡張子非特定の場合は、拡張子は空欄</small>
</h1>
</section>
    <!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-xs-12">
        <div class="mime-types form">
            <?= $this->Form->create($mimeType, ['role' => 'form']) ?>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= __('更新情報') ?></h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        echo $this->Form->input('mime_type', ['label'=>'MimeType名','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        echo $this->Form->input('ext', ['label'=>'拡張子','class' => 'form-control', 'placeholder' => __('入力 ...')]);
                        echo $this->Form->control('ambiguous', ['label'=>'拡張子が',
                            'options' => ['1' => '非特定', '0' => '特定']   ]);
                        ?>
                    </div>
                </div>
                <div class="box-footer">
                    <?= $this->Form->button(__('更新'), ['class'=>'btn btn-primary']) ?>
                    <?= $this->Html->link(__('キャンセル'), ['action' => 'view',$mimeType->id], ['class' => 'btn btn-warning']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</section>