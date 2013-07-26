<?php
/* @var $this TabsController */
/* @var $model Tabs */

$this->breadcrumbs=array(
	'Tabs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Список страниц', 'url'=>array('pages/index')),
	array('label'=>'Создать страницу', 'url'=>array('pages/create')),
	array('label'=>'Управление страницами', 'url'=>array('pages/admin')),
	array('label'=>'Список вкладок', 'url'=>array('tabs/index')),
	array('label'=>'Создать вкладку', 'url'=>array('tabs/create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#tabs-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js');
?>

<?php
$csrf_token_name = Yii::app()->request->csrfTokenName;
$csrf_token = Yii::app()->request->csrfToken;

$str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };

        $('#tabs-grid table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#tabs-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'}) + '&{$csrf_token_name}={$csrf_token}';
                $.ajax({
                    'url': '" . $this->createUrl('//tabs/sort') . "',
                    'type': 'post',
                    'data': serial,
                    'success': function(data){
                    },
                    'error': function(request, status, error){
                        alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    ";

Yii::app()->clientScript->registerScript('sortable-project', $str_js);
?>

<h1>Управление вкладками</h1>

<p>
	Вы также можете использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) перед поисковым значением для определения правил поиска.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tabs-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'rowCssClassExpression'=>'"items[]_{$data->tab_id}"',
	'columns'=>array(
		'tab_id',
		'tab_name',
		'tab_title',
		'tab_content',
		'tab_order',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
