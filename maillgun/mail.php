<?php
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-8a14df0c7f3b08f3d96693a347e78454');
$domain = "nini-sia-punk.rocks";

# Make the call to the client.
for ($i=0; $i < 50 ; $i++) {
  $result = $mgClient->sendMessage("$domain",
    array('from'    => 'taufantritama@gmail.com',
          'to'      => 'vulnwalker@yahoo.com',
          'subject' => 'test'.$i,
          'text'    => "test mail"));
}
?>
