<?php session_start(); //this line must be the 1st on your page ?>
<!---any html code can go here -->
<?php if(($_SESSION['give_reward2']=="YES") && ($_SESSION['nrofemailssent']>=$_SESSION['nrofemailstobesent'])) { ?>
Your html code if the user receives reward #2
<!---any html code can go here -->
<?php } else { ?>
Your html code if the user DO NOT receives reward #2
<!---any html code can go here -->
<?php } ?>
<!---any html code can go here -->