<?php
include_once('includes/functions.php');
get_header();
get_nav();
?>
<div class="dashboard-wrapper">
	<div class="left-sidebar">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-header">
						<div class="title">
							Truy cập nhanh
							<span class="mini-title">
								Metro UI Navigation
							</span>
						</div>
						<span class="tools">
							<a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
						</span>
					</div>
					<div class="widget-body">
						<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	get_sidebar('b');
	get_footer();
	?>