<?php
	$vcMsjSrv = (!empty($vcMsjSrv))? $vcMsjSrv: ''; 
?>
	<script type="text/javascript">
        $(document).on('ready', function(){
            $('#main_content').load('eventos/listado');
        });
	</script>