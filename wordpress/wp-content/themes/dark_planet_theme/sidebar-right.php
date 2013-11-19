		<!-- Sidebar -->
		<div class="sidebar">
			<div class="sidebar-box"><div class="sidebar-box-top"><div class="sidebar-box-bottom">
				<h3>Pages</h3>
				<ul>
					<?php wp_list_pages('title_li='); ?>
				</ul>
			</div></div></div>
			
			<div class="sidebar-box"><div class="sidebar-box-top"><div class="sidebar-box-bottom">
				<h3>Categories</h3>
				<ul>
					<?php wp_list_categories('title_li='); ?>
				</ul>
			
			
			</div></div></div>

			<div class="sidebar-box"><div class="sidebar-box-top"><div class="sidebar-box-bottom">
				<h3>Archives</h3>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
		
			</div></div></div>

			
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
			
			<?php endif; ?>
			
		</div>
		<!-- Sidebar -->