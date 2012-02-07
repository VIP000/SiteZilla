<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
WEBSITE_HEADER
	</head>
	<body>
		<div id="header">
			<div id="title">
				<h1>WEBSITE_NAME</h1>
			</div>
		</div>
		
		<div id="navbar">
			<ul>
				<!-- counterintuitively, right aligned items go first, from right to left -->
WEBSITE_MENU
			</ul>
		</div>
		<div id="shadow"></div>
		<div id="body">
			<div id="sidebar">
				<h2>Contents</h2>
				<ul class="tree">
WEBSITE_MENU
				</ul>
			</div>

			<div id="content">
WEBSITE_CONTENT
			</div>

			<div id="footer">
			WEBSITE_FOOTER  TEMPLATE_AUTHOR
			</div>
		</div>
	</body>
</html> 
