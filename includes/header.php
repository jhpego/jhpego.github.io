	<div id="header">
			<a href="#" id="foto"></a>
			<a href="#" id="logo"></a>
			<div id="profile">
				<?php
				echo $cv->personal->nationality,', ', age($cv->personal->birth), ' anos, ',$cv->personal->marital,'<br/>';
				writeIf ($cv->personal->address.' - ',2);
				echo $cv->personal->city,'<br/>';
				writeif ($cv->personal->mobile.'<br/>', 2);
				writeif($cv->personal->email.'<br/>', 2);
				?>
			</div>
	</div>