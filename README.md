# Vulnerable-Language-Changer

This PHP code has a RFI leading to RCE and shell access. Then a privilege escalation is performed giving the access to the final flag.

### RFI
The misconfiguration in `php.ini` file with `allow_url_include = On` leads the RFI.

LFI/RFI is caused due to the following code snippet:

```php
<?php
    $Language = parse_ini_file('lang//english.ini');

    if ( isset( $_GET['lang'] ) ) {

        include( $_GET['lang']);
        // end
        
    }
    
?>
```

`include()` function in the above code directly includes the file without any sanitization which leads to LFI. Then the misconfiguration leads to RFI.


### Privilege Escalation

Privilege Escalation is done from the exploitation of SUID Binary of base64. The `base64` is owned by `prithivi` user, which can be used to get the flag which is owned and read by only `prithivi`.

## Docker

Use`sudo docker pull 0x00ac/vulnerable-language-changer:inno` to pull and `sudo docker run -p 80:80 0x00ac/vulnerable-language-changer:innovision` run the docker image from the docker-hub.

Then have a look at `localhost` to get the problem.

# OR

Use the `docker-compose.yml` file to build and run the docker.
`sudo docker-compose up -d` to get the image up and running. Change the [server config](nginx/default.conf) asscording to the need while deploying.
