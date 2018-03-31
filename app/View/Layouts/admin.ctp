<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Projeto Eventos</title>
		<?php
		
			echo $this->Html->css(array(
	
		'reset',
		'grid',
		'site',
		
	));

	echo $this->Html->script(array(
				'angular',
				'admin'
		
	));
		
		?>
	</head>
	</head>

	<body>
		<!-- Header -->
		<div id="header">
			<div class="container">
			
			</div>
		</div>
		<!-- /Header -->
		
		<!-- Main -->
		<div id="main" >
			<div class="container" >
				
				<!-- Content -->
				<div id="content" class="grid_MAX">
					
					<?php echo $content_for_layout ?>
				</div> 
				<!-- /Content -->
				
			</div>
		</div>
		<!-- /Main -->
		
		<!-- Footer -->
		<div id="footer">

		</div>
		<!-- /Footer -->
						
	</body>
</html>