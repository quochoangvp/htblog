	<div class="right-sidebar">
	    <div class="wrapper">
	    	<div id="scrollbar">
	    		<div class="scrollbar" style="height: 340px;">
	    			<div class="track" style="height: 340px;">
	    				<div class="thumb" style="top: 0px; height: 88.1499395405079px;">
	    					<div class="end"></div>
    					</div>
					</div>
				</div>
				<h5 class="heading">Bài nhiều lượt xem</h5>
				<div class="viewport">
                	<div class="overview" style="top: 0px;">
                		<div class="featured-articles-container">
                			<div class="articles">
                				<?php
							       if (sidebar_recent_posts()) {
							            echo sidebar_recent_posts();
							        }
							    ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr class="hr-stylish-1"/>
		<div class="wrapper">
	    	<div id="scrollbar-two">
	    		<div class="scrollbar" style="height: 340px;">
	    			<div class="track" style="height: 340px;">
	    				<div class="thumb" style="top: 0px; height: 88.1499395405079px;">
	    					<div class="end"></div>
    					</div>
					</div>
				</div>
				<h5 class="heading-blue">Bài mới đăng</h5>
                <div class="viewport">
                	<div class="overview" style="top: 0px;">
                		<div class="featured-articles-container">
                			<div class="articles">
                				<?php
							       if (sidebar_recent_posts()) {
							            echo sidebar_recent_posts();
							        }
							    ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div><!-- .dashboard-wrapper -->