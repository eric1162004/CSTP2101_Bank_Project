<?php

function renderHeader($css_path){
  echo "
    <!DOCTYPE html>
    <html lang='en'>
      <head>
        <meta charset='utf-8' />
        <meta http-equiv='x-ua-compatible' content='ie=edge' />
        <meta name='viewport' content='width=device-width, initial-scale=1' />
    
        <title>Group 2 Bank Database Interface</title>
    
        <link href='https://fonts.googleapis.com/css2?family=Open+Sans&display=swap' rel='stylesheet'>
        <link rel='stylesheet' href='$css_path' />
      </head>
    
      <body>
        <h1>Group 2 Bank Database Interface</h1>
      </body>
    </html>
  ";
}

?>