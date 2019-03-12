<!-- error loop will output/append the error to the page to show the user what the issue is 
if statement determines if there are any errors and if so puts you through 
to a for loop which will loop the number of errors and output each error -->
<?php  if (count($errors) > 0) : ?>
  <div class="error">
		<!-- for loop which will loop over the number of errors outputting each error one after another -->
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
			<!-- end of for loop -->
  	<?php endforeach ?>
  </div>
	<!-- end of if statement -->
<?php  endif ?>