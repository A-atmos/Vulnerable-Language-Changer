# Vulnerable-Language-Changer

This PHP code has a RFI leading to RCE and shell access.

The misconfiguration in `php.ini` file with `allow_url_include = On` leads the LFI to RFI.

LFI is caused due to the following code snippet:

```php
<?php
    $Language = parse_ini_file('lang//english.ini');

    if ( isset( $_GET['lang'] ) ) {

        include( $_GET['lang']);
        // end
        
    }
    
?>
```

`include()` function in the above code directly includes the file without any sanitization which leads to LFI.