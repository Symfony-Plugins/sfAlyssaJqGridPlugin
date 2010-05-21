<?php $grid = $sf_data->getRaw('grid'); ?>
<div id="grid-example">
<table>
<?php echo $grid->render() ?>
</table>
</div>



<script type='text/javascript'>
jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
</script>
