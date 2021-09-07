  <div class="footer">
	 <div>
		<p>
		   <a href="http://validator.w3.org/check?uri=referer"><img
			  src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
		</p>
		<p>
		   <a href="http://jigsaw.w3.org/css-validator/check/referer">
		   <img style="border:0;width:88px;height:31px"
			  src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
			  alt="Valid CSS!" />
		   </a>
		</p>
	 </div>
	 <div>
		<!-- output last mod information -->
		<?php print ("<p>Last modified: " . date("D M d Y",getlastmod())."</p>");?> 
	 </div>
  </div>
  <script type="text/javascript" src="scripts/script.js"></script>
</body>
</html>
<?php ob_end_flush(); ?>  
