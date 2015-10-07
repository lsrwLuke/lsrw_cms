<main id="lsrw_main">
				<header class="lsrw_panel_header">Add New Page</header>
				<div class="lsrw_panel_content">
					<form class="lsrw_form" method="POST" action="./">
						<h2><label for="title">Page Title</label></h2>
						<input type="text" name="title" id="title" autocomplete="off"/>
						<h2>Page Content</h2>
						<script src="./lsrw_assets/editor/ckeditor.js"></script>
						<textarea name="editor" id="editor"></textarea>
						<script>
						CKEDITOR.replace( 'editor', {
							height: 260
						} );
						</script>
						<h2>Page Options</h2>
						<input type="submit" id="submit" value="Create New Post"/>
					</form>				
				</div>
			</main>